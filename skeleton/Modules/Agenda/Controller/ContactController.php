<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\PublicResourceController;
use Alxarafe\Attribute\Menu;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Textarea;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use Modules\Agenda\Model\Address;
use Modules\Agenda\Model\Contact;
use Modules\Agenda\Model\ContactChannel;

/**
 * Controller for managing contacts in the Agenda module.
 * Provides list and edit views with tabs for addresses and channels.
 */
#[Menu(
    menu: 'main_menu',
    label: 'agenda',
    icon: 'fas fa-address-book',
    order: 15,
    visibility: 'public'
)]
#[Menu(
    menu: 'main_menu',
    label: 'contacts',
    icon: 'fas fa-users',
    order: 1,
    parent: 'agenda',
    visibility: 'public'
)]
class ContactController extends PublicResourceController
{
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Agenda';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'Contact';
    }

    #[\Override]
    protected function getModelClass()
    {
        return Contact::class;
    }

    #[\Override]
    protected function getListColumns(): array
    {
        return [
            new Text('first_name', Trans::_('first_name')),
            new Text('last_name', Trans::_('last_name')),
        ];
    }

    #[\Override]
    protected function getEditFields(): array
    {
        return [
            'general' => [
                'label' => Trans::_('general'),
                'fields' => [
                    new Text('first_name', Trans::_('first_name'), [
                        'required' => true,
                        'placeholder' => Trans::_('first_name_placeholder'),
                    ]),
                    new Text('last_name', Trans::_('last_name'), [
                        'placeholder' => Trans::_('last_name_placeholder'),
                    ]),
                    new Textarea('notes', Trans::_('notes'), [
                        'rows' => 4,
                        'placeholder' => Trans::_('notes_placeholder'),
                    ]),
                ],
            ],
        ];
    }

    /**
     * Set custom template and pass relationship data for the edit view.
     */
    #[\Override]
    protected function beforeEdit()
    {
        // Register the module's Templates directory
        $templatesPath = realpath(defined('APP_PATH') ? constant('APP_PATH') : __DIR__ . '/../..') . '/Modules/Agenda/Templates';
        if (is_dir($templatesPath)) {
            $this->addTemplatesPath($templatesPath);
        }

        $this->setDefaultTemplate('contact_edit');

        // Load relationship data for existing contacts
        if ($this->recordId && $this->recordId !== 'new') {
            $contact = Contact::with(['addresses', 'channels'])->find($this->recordId);
            if ($contact) {
                $this->addVariable('contact_addresses', $contact->addresses);
                $this->addVariable('contact_channels', $contact->channels);
            } else {
                $this->addVariable('contact_addresses', collect());
                $this->addVariable('contact_channels', collect());
            }
        } else {
            $this->addVariable('contact_addresses', collect());
            $this->addVariable('contact_channels', collect());
        }

        // Always provide channel types for the selector, with translations
        $channelTypes = ContactChannel::all();
        foreach ($channelTypes as $ct) {
            $ct->trans_name = Trans::_($ct->name);
        }
        $this->addVariable('channel_types', $channelTypes);

        // Provide standard address labels for the datalist
        $standardLabels = [];
        foreach ($this->getStandardAddressLabels() as $key) {
            $standardLabels[$key] = Trans::_($key);
        }
        $this->addVariable('standard_address_labels', $standardLabels);
    }

    /**
     * Save contact with addresses and channels relationships.
     */
    #[\Override]
    protected function saveRecord()
    {
        $id = $_POST['id'] ?? null;
        $isNew = ($id === 'new' || empty($id));

        // 1. Save main contact data
        if ($isNew) {
            $contact = new Contact();
        } else {
            $contact = Contact::find($id);
            if (!$contact) {
                throw new \Exception("Contact not found with ID: " . htmlspecialchars((string)$id));
            }
        }

        $contact->first_name = $_POST['first_name'] ?? '';
        $contact->last_name = $_POST['last_name'] ?? null;
        $contact->notes = $_POST['notes'] ?? null;
        $contact->save();

        // 2. Sync addresses (only for existing contacts)
        if (!$isNew && isset($_POST['addresses'])) {
            $this->syncAddresses($contact, $_POST['addresses']);
        }

        // 3. Sync channels (only for existing contacts)
        if (!$isNew && isset($_POST['channels'])) {
            $this->syncChannels($contact, $_POST['channels']);
        }

        $this->recordId = (string)$contact->id;

        // Redirect back to the contact list
        Functions::httpRedirect(static::url());
    }

    /**
     * Sync addresses from form data to the contact.
     */
    private function syncAddresses(Contact $contact, array $addressData): void
    {
        // Collect submitted address IDs to determine which to detach
        $submittedIds = [];

        foreach ($addressData as $item) {
            $addrId = $item['id'] ?? 'new';
            $label = $item['label'] ?? null;

            // Reverse translation: if the label matches a standard key's translation, store the key
            if ($label) {
                foreach ($this->getStandardAddressLabels() as $key) {
                    if ($label === Trans::_($key)) {
                        $label = '#' . $key;
                        break;
                    }
                }
            }

            if ($addrId === 'new' || empty($addrId)) {
                // Create a new address
                if (empty($item['address'])) {
                    continue; // Skip empty entries
                }
                $address = Address::create([
                    'address' => $item['address'],
                    'city' => $item['city'] ?? null,
                    'state' => $item['state'] ?? null,
                    'postal_code' => $item['postal_code'] ?? null,
                    'country' => $item['country'] ?? null,
                    'additional_info' => $item['additional_info'] ?? null,
                ]);
                $contact->addresses()->attach($address->id, ['label' => $label]);
                $submittedIds[] = $address->id;
            } else {
                // Update existing address
                $address = Address::find($addrId);
                if ($address) {
                    $address->update([
                        'address' => $item['address'] ?? $address->address,
                        'city' => $item['city'] ?? $address->city,
                        'state' => $item['state'] ?? $address->state,
                        'postal_code' => $item['postal_code'] ?? $address->postal_code,
                        'country' => $item['country'] ?? $address->country,
                        'additional_info' => $item['additional_info'] ?? $address->additional_info,
                    ]);
                    // Update the pivot label
                    $contact->addresses()->updateExistingPivot($address->id, ['label' => $label]);
                    $submittedIds[] = (int)$addrId;
                }
            }
        }

        // Detach addresses no longer in the form
        $currentIds = $contact->addresses()->pluck('addresses.id')->toArray();
        $toDetach = array_diff($currentIds, $submittedIds);
        if (!empty($toDetach)) {
            $contact->addresses()->detach($toDetach);
        }
    }

    /**
     * Sync channels from form data to the contact.
     */
    private function syncChannels(Contact $contact, array $channelData): void
    {
        // Build the sync array: channel_id => ['value' => ...]
        $syncData = [];

        foreach ($channelData as $item) {
            $channelId = $item['channel_id'] ?? null;
            $value = $item['value'] ?? '';

            if (!$channelId || empty($value)) {
                continue; // Skip empty entries
            }

            // Note: sync allows duplicate channel_ids with different values
            // But for simplicity, use attach approach
            $syncData[] = [
                'contact_channel_id' => (int)$channelId,
                'value' => $value,
            ];
        }

        // Detach all existing and re-attach
        $contact->channels()->detach();
        foreach ($syncData as $entry) {
            $contact->channels()->attach($entry['contact_channel_id'], ['value' => $entry['value']]);
        }
    }

    /**
     * Standard keys for address labels that should be translatable.
     *
     * @return array
     */
    private function getStandardAddressLabels(): array
    {
        return ['home', 'work', 'billing', 'shipping', 'other'];
    }
}
