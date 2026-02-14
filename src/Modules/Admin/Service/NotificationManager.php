<?php

namespace CoreModules\Admin\Service;

use CoreModules\Admin\Model\Notification;
use Alxarafe\Lib\Auth;

class NotificationManager
{
    /**
     * Add a notification for a user or global.
     *
     * @param string $message
     * @param string $type info, warning, error, success
     * @param int|null $userId Null for global
     * @param string|null $link Optional link
     * @return Notification
     */
    public static function add(string $message, string $type = 'info', ?int $userId = null, ?string $link = null): Notification
    {
        /** @var Notification $notification */
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'link' => $link,
            'read' => false
        ]);
        return $notification;
    }

    /**
     * Get unread notifications for the current user.
     * Includes global notifications (user_id is null).
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUnread()
    {
        $userId = Auth::$user->id ?? null;
        if (!$userId) {
            return collect();
        }

        return Notification::where('read', false)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereNull('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get recent notifications (read or unread)
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getRecent($limit = 5)
    {
        $userId = Auth::$user->id ?? null;
        if (!$userId) {
            return collect([]);
        }

        return Notification::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhereNull('user_id');
        })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function markAsRead($id)
    {
        /** @var Notification|null $notification */
        $notification = Notification::find($id);
        $userId = Auth::$user->id ?? null;
        if ($notification && ($notification->user_id == $userId || $notification->user_id === null)) {
            // If it's global, we might need a pivot table to track reads per user.
            // For now, let's assume global notifications are transient or handle them simply.
            // If the user_id is null, marking it read would hide it for everyone if we just update the row.
            // Requirement says "global or another user".
            // Implementation Detail: For true global notifications, we'd need a `notification_status` table.
            // Given the complexity constraints, I'll stick to direct assignment for now unless the user asks for read-tracking on globals.
            // But if it's GLOBAL, maybe we shouldn't mark it read on the record itself? Or maybe we just don't support "mark read" for globals yet?

            // Let's protect global notifications from being marked read by one user.
            if ($notification->user_id !== null) {
                $notification->update(['read' => true, 'read_at' => date('Y-m-d H:i:s')]);
            }
        }
    }
}
