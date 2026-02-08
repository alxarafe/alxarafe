export interface StructConfig {
    mode: 'list' | 'edit';
    recordId?: string | number;
    protectChanges?: boolean;
    config: {
        list?: {
            tabs: Record<string, any>;
            head_buttons: any[];
            limit: number;
        };
        edit?: {
            sections: Record<string, any>;
            actions: any[];
        };
    };
    templates?: Record<string, string>;
}

export class AlxarafeResource {
    private container: HTMLElement;
    private config: StructConfig;
    private activeTab: string = '';
    private currentOffset: number = 0;
    private activeFilters: Record<string, string> = {};
    private searchDebounceTimer: any = null;
    // Using global window.alxarafe_unsaved_changes

    constructor(container: HTMLElement, config: StructConfig) {
        this.container = container;
        this.config = config;
        this.init();
    }

    private init() {
        if (this.config.mode === 'list') {
            this.activeTab = Object.keys(this.config.config.list?.tabs || {})[0] || '';

            // Initialize filters with defaults from config if present
            const tabs = this.config.config.list?.tabs || {};
            if (tabs[this.activeTab]?.filters) {
                tabs[this.activeTab].filters.forEach((f: any) => {
                    if (f.value) this.activeFilters[f.field] = f.value;
                });
            }

            this.renderListLayout();
            this.fetchData();
        } else {
            this.renderEdit();
            // Global script in footer handles beforeunload if protectChanges is true
        }
        this.injectStyles();
    }

    // Removed setupUnsavedChangesProtection as it is handled globally in footer.blade.php

    private injectStyles() {
        const styleId = 'alxarafe-resource-styles';
        if (document.getElementById(styleId)) return;

        const style = document.createElement('style');
        style.id = styleId;
        style.innerHTML = `
            /* Scoped Select2 Fixes for Alxarafe Resource */
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection {
                min-height: calc(1.5em + 0.75rem + 2px) !important; /* Standard BS5 input height */
                padding: 0.375rem 0.75rem !important;
                display: flex !important;
                align-items: center !important;
            }
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection__rendered {
                line-height: 1.5 !important;
                color: #212529 !important;
                padding-left: 0 !important; /* Reset padding as parent has it */
            }
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection__placeholder {
                line-height: 1.5 !important;
            }
            /* Fix Dropdown too */
            .select2-container--bootstrap-5 .select2-dropdown .select2-results__option {
                padding: 0.375rem 0.75rem !important;
            }
        `;
        document.head.appendChild(style);
    }

    // --- LIST MODE METHODS ---

    private renderListLayout() {
        const tabs = this.config.config.list?.tabs || {};
        const currentTab = tabs[this.activeTab];

        if (!currentTab) {
            this.container.innerHTML = '<div class="alert alert-danger">Configuration Error: Active tab not found.</div>';
            return;
        }

        const buttons = this.config.config.list?.head_buttons || [];
        const leftButtons = buttons.filter((b: any) => b.location === 'left');
        const rightButtons = buttons.filter((b: any) => !b.location || b.location === 'right');

        const renderBtn = (b: any) => `
            <button class="btn btn-sm btn-${b.type}" 
                    ${b.action === 'js' ? `onclick="${b.target}"` : `onclick="window.location.href='${b.target}'"`}>
                <i class="${b.icon} me-1"></i> ${b.label}
            </button>
        `;

        // Require template
        if (!this.config.templates || !this.config.templates['layout_list']) {
            this.container.innerHTML = '<div class="alert alert-danger">Internal Error: Missing template "layout_list"</div>';
            return;
        }

        this.container.innerHTML = this.config.templates['layout_list'];

        // Inject Tabs
        const tabsContainer = this.container.querySelector('#alxarafe-tabs-container');
        if (tabsContainer) tabsContainer.innerHTML = this.renderTabsNav();

        // Inject Buttons
        const leftContainer = this.container.querySelector('#alxarafe-toolbar-left');
        if (leftContainer) leftContainer.innerHTML = leftButtons.map(renderBtn).join('');

        const rightContainer = this.container.querySelector('#alxarafe-toolbar-right');
        if (rightContainer) rightContainer.innerHTML = rightButtons.map(renderBtn).join('');

        // Inject Table Headers
        const theadRow = this.container.querySelector('#alxarafe-table-head');
        if (theadRow) {
            theadRow.innerHTML = currentTab.columns.map((col: any) => `
                    <th class="py-3 px-4 border-0">${col.label}</th>
                `).join('') + '<th class="text-end py-3 px-4 border-0" style="width: 120px;">Acciones</th>';
        }

        this.renderFilters(currentTab.filters || []);

        // Setup toggle icon rotation logic (simple CSS or JS listener)
        const collapseEl = this.container.querySelector('#alxarafe-filters-collapse');
        if (collapseEl) {
            collapseEl.addEventListener('hide.bs.collapse', () => {
                this.container.querySelector('.card-header .fa-chevron-up')?.classList.replace('fa-chevron-up', 'fa-chevron-down');
            });
            collapseEl.addEventListener('show.bs.collapse', () => {
                this.container.querySelector('.card-header .fa-chevron-down')?.classList.replace('fa-chevron-down', 'fa-chevron-up');
            });
        }

        this.setupAlertHelper();
    }

    private setupAlertHelper() {
        if (!document.getElementById('alxarafe-alerts')) {
            const alertsDiv = document.createElement('div');
            alertsDiv.id = 'alxarafe-alerts';
            this.container.prepend(alertsDiv);
        }
    }

    private showMessage(msg: string, type: 'success' | 'danger' | 'info' = 'info') {
        const alertsDiv = document.getElementById('alxarafe-alerts');
        if (!alertsDiv) return;

        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        alertsDiv.insertAdjacentHTML('beforeend', alertHtml);
    }

    private renderTabsNav() {
        const tabs = this.config.config.list?.tabs || {};
        const tabKeys = Object.keys(tabs);
        if (tabKeys.length <= 1) return '';

        return `
            <ul class="nav nav-tabs mb-4">
                ${tabKeys.map(key => `
                    <li class="nav-item">
                        <a class="nav-link ${this.activeTab === key ? 'active' : ''}" 
                           href="#" 
                           data-tab="${key}"
                           onclick="event.preventDefault();">
                           ${tabs[key].title || tabs[key].label || key}
                        </a>
                    </li>
                `).join('')}
            </ul>
        `;
    }

    private handleTabClick(e: Event) {
        const target = (e.target as HTMLElement).closest('.nav-link') as HTMLElement;
        if (!target) return;

        const newTab = target.dataset.tab;
        if (newTab && newTab !== this.activeTab) {
            this.activeTab = newTab as string;
            this.currentOffset = 0;
            // Clear active filters when switching tabs
            this.activeFilters = {};

            // Re-render layout
            this.renderListLayout();
            this.fetchData();
        }
    }

    private renderFilters(filters: any[]) {
        const row = this.container.querySelector('#alxarafe-filters-row');
        // Re-bind tab events logic if we just re-rendered layout
        this.container.querySelectorAll('.nav-tabs .nav-link').forEach(link => {
            link.addEventListener('click', (e) => this.handleTabClick(e));
        });

        if (!row) return;

        if (filters.length === 0) {
            this.container.querySelector('#alxarafe-filters-container')?.remove();
            return;
        }

        row.innerHTML = filters.map((f: any) => {
            const val = this.activeFilters[f.field] || '';
            const clearBtn = val ? `
                <button class="btn btn-outline-secondary alxarafe-filter-clear" type="button" data-field="${f.field}">
                    <i class="fas fa-times"></i>
                </button>
            ` : '';

            if (f.type === 'text') {
                return `
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="text"
                                class="form-control alxarafe-filter-input"
                                data-field="${f.field}"
                                placeholder="${f.label}..."
                                value="${val}">
                            ${clearBtn}
                        </div>
                    </div>
                `;
            }
            else if (f.type === 'select' || f.type === 'select2') {
                const isSelect2 = f.type === 'select2';
                const options = Object.entries(f.options || {}).map(([k, v]) =>
                    `<option value="${k}" ${String(k) === String(val) ? 'selected' : ''}>${v}</option>`
                ).join('');

                if (isSelect2) {
                    return `
                    <div class="col-md-3 alxarafe-select2-wrapper">
                        <select class="form-select form-select-sm alxarafe-filter-input select2" data-field="${f.field}" style="width: 100%" data-placeholder="-- ${f.label} --">
                            <option value="">-- ${f.label} --</option>
                            ${options}
                        </select>
                    </div>`;
                } else {
                    return `
                    <div class="col-md-3">
                         <div class="input-group input-group-sm">
                            <select class="form-select alxarafe-filter-input" data-field="${f.field}">
                                <option value="">-- ${f.label} --</option>
                                ${options}
                            </select>
                            ${val ? clearBtn : ''}
                        </div>
                    </div>
                `;
                }
            }
            return '';
        }).join('');

        // Attach clear events
        row.querySelectorAll('.alxarafe-filter-clear').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const field = (e.currentTarget as HTMLElement).dataset.field;
                this.clearFilter(field);
            });
        });

        // Initialize Select2 if available
        if (typeof (window as any).refrescar_select2 === 'function') {
            (window as any).refrescar_select2();

            // Handle Select2 Change (using jQuery from global)
            const $ = (window as any).jQuery;
            if ($) {
                $(row).find('.select2').on('change', (e: any) => {
                    const field = e.target.getAttribute('data-field');
                    const val = $(e.target).val();
                    this.activeFilters[field] = val;
                    this.currentOffset = 0;
                    this.fetchData();
                });
            }
        }

        // Attach events
        row.querySelectorAll('.alxarafe-filter-input:not(.select2)').forEach(input => {
            if (input.tagName === 'SELECT') {
                input.addEventListener('change', (e) => this.handleFilterChange(e));
            } else {
                input.addEventListener('input', (e) => this.handleFilterChange(e));
            }
        });
    }

    private handleFilterChange(e: Event) {
        const target = e.target as HTMLInputElement | HTMLSelectElement;
        const field = target.dataset.field;
        if (!field) return;

        const val = target.value;
        this.activeFilters[field] = val;

        // Reset offset on filter change
        this.currentOffset = 0;

        // Debounce for text inputs
        if (target.type === 'text') {
            clearTimeout(this.searchDebounceTimer);
            this.searchDebounceTimer = setTimeout(() => this.fetchData(), 300);
        } else {
            this.fetchData();
        }

        // Re-render filters (to toggle clear buttons)
        this.renderFilters(this.getFiltersConfig());
    }

    private clearFilter(field: string | undefined) {
        if (!field) return;
        delete this.activeFilters[field];
        this.currentOffset = 0;
        this.fetchData();
        this.renderFilters(this.getFiltersConfig());
    }

    private getFiltersConfig() {
        const tabs = this.config.config.list?.tabs || {};
        const currentTab = tabs[this.activeTab];
        return currentTab ? (currentTab.filters || []) : [];
    }

    private async fetchData() {
        this.setTableLoading(true);

        const url = new URL(window.location.href);
        url.searchParams.set('ajax', 'get_data');
        url.searchParams.set('tab', this.activeTab);
        url.searchParams.set('offset', String(this.currentOffset));

        // Add filters to URL
        Object.entries(this.activeFilters).forEach(([key, val]) => {
            if (val) url.searchParams.set(`filter_${this.activeTab}_${key}`, val);
        });

        try {
            const response = await fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Network error');
            const result = await response.json();

            this.populateTable(result.data);
            this.renderPagination(result.meta);

        } catch (error) {
            this.showTableError(String(error));
        }
    }

    private populateTable(rows: any[]) {
        const tbody = this.container.querySelector('#alxarafe-table-body');
        if (!tbody) return;

        if (!rows || rows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="100" class="text-center p-4 text-muted">No se encontraron resultados.</td></tr>';
            return;
        }

        const currentTab = this.config.config.list?.tabs?.[this.activeTab];

        tbody.innerHTML = rows.map((row: any) => `
            <tr onclick="window.location.href='?${this.getRoutingParams()}&id=${row.id ?? row.code}'" style="cursor: pointer; transition: background-color 0.2s;">
                ${currentTab.columns.map((col: any) => `
                    <td class="px-4 py-3 text-secondary">${this.formatValue(row[col.field], col, row)}</td>
                `).join('')}
                <td class="text-end px-4 py-3">
                    <a href="?${this.getRoutingParams()}&id=${row.id ?? row.code}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Editar">
                        <i class="fas fa-pen small"></i>
                    </a>
                </td>
            </tr>
        `).join('');

        // Trigger local data formatting after render
        this.formatLocalData();
    }

    private formatLocalData() {
        // 1. Dates
        const dateEls = this.container.querySelectorAll('.alx-date-local');
        dateEls.forEach((el: any) => {
            const val = el.dataset.value;
            if (!val) return;
            try {
                const date = new Date(val);
                if (!isNaN(date.getTime())) {
                    el.innerText = date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
                }
            } catch (e) { }
        });

        // 2. DateTimes
        const dateTimeEls = this.container.querySelectorAll('.alx-datetime-local');
        dateTimeEls.forEach((el: any) => {
            const val = el.dataset.value;
            if (!val) return;
            try {
                const date = new Date(val);
                if (!isNaN(date.getTime())) {
                    el.innerText = date.toLocaleString();
                }
            } catch (e) { }
        });

        // 3. Decimals / Numbers
        const decimalEls = this.container.querySelectorAll('.alx-decimal-local');
        decimalEls.forEach((el: any) => {
            const val = parseFloat(el.dataset.value);
            if (isNaN(val)) return;
            try {
                el.innerText = val.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 });
            } catch (e) { }
        });

        // 4. Time
        const timeEls = this.container.querySelectorAll('.alx-time-local');
        timeEls.forEach((el: any) => {
            // Time usually comes as HH:MM:SS. We can just show it as is or try to format it?
            // Browser doesn't have a simple "Time String Formatter" from just a time string without date.
            // We can use a dummy date.
            const val = el.dataset.value;
            if (!val) return;
            // Basic check if it is HH:MM:SS
            if (val.includes(':')) {
                // Leave as is or format:
                // el.innerText = val.substring(0, 5); // HH:MM
                // Let's truncate seconds if they are 00?
                // User wants "browser configuration". Browser usually shows HH:MM for time inputs.
                // Let's stick with HH:MM
                if (val.length === 8) {
                    el.innerText = val.substring(0, 5);
                }
            }
        });
    }

    private renderPagination(meta: any) {
        const container = this.container.querySelector('#alxarafe-pagination');
        if (!container) return;

        const { total, limit, offset } = meta;
        const currentPage = Math.floor(offset / limit) + 1;
        const totalPages = Math.ceil(total / limit);
        const start = offset + 1;
        const end = Math.min(offset + limit, total);

        if (total === 0) {
            container.innerHTML = '';
            return;
        }

        const buildPageItem = (page: number | string, label: string, disabled: boolean = false, active: boolean = false) => `
            <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
                <button class="page-link" ${typeof page === 'number' ? `data-page="${page}"` : ''} ${typeof page !== 'number' ? 'disabled' : ''}>${label}</button>
            </li>
        `;

        // Logic for sliding window
        let pagesParams: (number | string)[] = [];

        if (totalPages <= 7) {
            for (let i = 1; i <= totalPages; i++) pagesParams.push(i);
        } else {
            pagesParams.push(1);
            if (currentPage > 3) pagesParams.push('...');
            for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                pagesParams.push(i);
            }
            if (currentPage < totalPages - 2) pagesParams.push('...');
            pagesParams.push(totalPages);
        }

        const itemsHtml = `
            ${buildPageItem(currentPage - 1, '<i class="fas fa-chevron-left"></i>', currentPage === 1)}
            ${pagesParams.map(p => {
            if (p === '...') return '<li class="page-item disabled"><span class="page-link">...</span></li>';
            return buildPageItem(p, String(p), false, p === currentPage);
        }).join('')}
            ${buildPageItem(currentPage + 1, '<i class="fas fa-chevron-right"></i>', currentPage === totalPages)}
        `;

        if (this.config.templates && this.config.templates['layout_pagination']) {
            let html = this.config.templates['layout_pagination'];
            html = html.split('{{start}}').join(String(start));
            html = html.split('{{end}}').join(String(end));
            html = html.split('{{total}}').join(String(total));
            html = html.split('{{items}}').join(itemsHtml);
            container.innerHTML = html;
        } else {
            container.innerHTML = '<div class="alert alert-warning">Missing template: layout_pagination</div>';
        }

        container.querySelectorAll('button[data-page]:not([disabled])').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const target = e.target as HTMLElement;
                const btnEl = target.closest('button');
                if (!btnEl || !btnEl.dataset.page) return;
                const targetPage = parseInt(btnEl.dataset.page);
                this.currentOffset = (targetPage - 1) * limit;
                this.fetchData();
            });
        });
    }

    private setTableLoading(loading: boolean) {
        const tbody = this.container.querySelector('#alxarafe-table-body');
        if (!tbody) return;
        if (loading) {
            const cols = (this.config.config.list?.tabs?.[this.activeTab]?.columns?.length || 0) + 1;
            tbody.innerHTML = `<tr><td colspan="${cols}" class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><br>Cargando...</td></tr>`;
        }
    }

    private showTableError(msg: string) {
        const tbody = this.container.querySelector('#alxarafe-table-body');
        if (tbody) tbody.innerHTML = `<tr><td colspan="100" class="text-center text-danger p-4">Error: ${msg}</td></tr>`;
    }

    // --- UTILS ---

    private formatValue(cellValue: any, col: any, row: any): string {
        if (typeof col === 'string') {
            col = { type: col };
        }

        // 1. If PHP already resolved the value (e.g. "Spain"), use it.
        // PHP ResourceController::processResultModels resolves dot notation into flat keys.
        let value = cellValue;

        // 2. Only if value is missing, retry dot notation on the full row object (redundancy)
        if ((value === null || value === undefined) && col.field && col.field.includes('.')) {
            try {
                value = col.field.split('.').reduce((acc: any, part: string) => (acc && acc[part] !== undefined) ? acc[part] : null, row);
            } catch (e) { value = null; }
        }

        const type = col.component || col.type || 'text';

        // Try generic template first (Including date/datetime now)
        const tpl = this.config.templates?.[type.toLowerCase() + '_list'];
        if (tpl) {
            let html = tpl;
            const safeValue = value !== null && value !== undefined ? value : '';
            html = html.split('{{value}}').join(safeValue);

            // Boolean check
            if (type === 'boolean') {
                const isChecked = safeValue === true || safeValue === 1 || safeValue === '1' || safeValue === 'true';
                html = html.split('{{checked}}').join(isChecked ? 'checked' : '');
            } else {
                html = html.split('{{checked}}').join('');
            }

            // Date formatting in list
            if (type === 'date' && safeValue) {
                try {
                    const date = new Date(safeValue);
                    if (!isNaN(date.getTime())) {
                        const formatted = date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
                        html = html.split(safeValue).join(formatted);
                    }
                } catch (e) { }
            }

            return html;
        }

        // Fallback Logic
        if (value === null || value === undefined) return '';

        if (col.type === 'icon' || col.component === 'icon') {
            const map = col.map || {};
            const iconClass = map[String(value)] !== undefined ? map[String(value)] : '';
            if (iconClass) {
                return `<i class="${iconClass}"></i>`;
            }
            return '';
        }

        if (col.type === 'boolean') {
            const isChecked = Boolean(value) && String(value) !== '0';
            return `<div class="text-center"><input type="checkbox" class="form-check-input" ${isChecked ? 'checked' : ''} disabled></div>`;
        }

        // Date/Datetime HARDCODED LOGIC REMOVED - using templates now.

        return String(value);
    }

    private getRoutingParams(): string {
        const url = new URL(window.location.href);
        const params = new URLSearchParams();
        if (url.searchParams.has('page')) params.set('page', url.searchParams.get('page')!);
        if (url.searchParams.has('module')) params.set('module', url.searchParams.get('module')!);
        if (url.searchParams.has('controller')) params.set('controller', url.searchParams.get('controller')!);
        return params.toString();
    }

    // --- EDIT MODE METHODS ---

    private renderEdit() {
        if (this.config.templates && this.config.templates['layout_edit']) {
            this.container.innerHTML = this.config.templates['layout_edit'];
        } else {
            this.container.innerHTML = '<div class="alert alert-danger">Internal Error: Missing template "layout_edit"</div>';
            return;
        }

        this.loadRecordData();
        this.setupAlertHelper();

        const btnSave = this.container.querySelector('#btn-save');
        if (btnSave) {
            btnSave.addEventListener('click', () => this.handleSave());

            // Add Revert Button next to Save
            const btnRevert = document.createElement('button');
            btnRevert.type = 'button';
            btnRevert.className = 'btn btn-secondary ms-2';
            btnRevert.innerHTML = '<i class="fas fa-sync-alt me-1"></i> Recargar';
            btnRevert.onclick = () => {
                if (confirm('¿Seguro que quieres descartar los cambios y recargar los datos originales?')) {
                    this.loadRecordData();
                    (window as any).alxarafe_unsaved_changes = false;
                }
            };
            btnSave.parentNode?.insertBefore(btnRevert, btnSave.nextSibling);
        }
    }

    private async loadRecordData() {
        const url = new URL(window.location.href);
        url.searchParams.set('ajax', 'get_record');

        try {
            const response = await fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const result = await response.json();

            if (result.error) throw new Error(result.error);

            this.buildForm(result.data);

        } catch (error) {
            const container = this.container.querySelector('#edit-form-container');
            if (container) container.innerHTML = `<div class="alert alert-danger">Error: ${error}</div>`;
        }
    }

    private buildForm(data: any) {
        const container = this.container.querySelector('#edit-form-container');
        if (!container) return;

        const sections = this.config.config.edit?.sections || {};
        const entries = Object.entries(sections);

        if (entries.length === 0) {
            container.innerHTML = '<div class="alert alert-warning">No sections defined</div>';
            return;
        }

        // 1. Build Nav Tabs
        let navHtml = '<ul class="nav nav-tabs mb-3" role="tablist">';
        entries.forEach(([secId, sec]: [string, any], index) => {
            const activeClass = index === 0 ? 'active' : '';
            navHtml += `
                <li class="nav-item" role="presentation">
                    <button class="nav-link ${activeClass}" id="${secId}-tab" data-bs-toggle="tab" data-bs-target="#tab-${secId}" type="button" role="tab">
                        ${sec.title}
                    </button>
                </li>
            `;
        });
        navHtml += '</ul>';

        // 2. Build Tab Content
        let contentHtml = '<form id="alxarafe-edit-form"><div class="tab-content">';
        entries.forEach(([secId, sec]: [string, any], index) => {
            const activeClass = index === 0 ? 'show active' : '';
            contentHtml += `
                <div class="tab-pane fade ${activeClass}" id="tab-${secId}" role="tabpanel">
                    <div class="container-fluid p-0">
                        <div class="row">
            `;

            // If fields are defined in the section configuration (from getEditFields), use them
            // This preserves order and specific configurations like readonly, label overrides, etc.
            if (sec.fields) {
                // Ensure sec.fields is an array (it comes as an object/array from PHP)
                const fieldsArray = Object.values(sec.fields);
                fieldsArray.forEach((field: any) => {
                    const value = data[field.field] !== undefined ? data[field.field] : '';
                    contentHtml += this.renderField(field, value);
                });
            }

            contentHtml += `
                        </div>
                    </div>
                </div>
            `;
        });
        contentHtml += '</div></form>';

        container.innerHTML = navHtml + contentHtml;

        // Monitor changes
        if (this.config.protectChanges) {
            const form = container.querySelector('form');
            if (form) {
                form.addEventListener('input', () => { (window as any).alxarafe_unsaved_changes = true; });
                form.addEventListener('change', () => { (window as any).alxarafe_unsaved_changes = true; });
            }
        }
    }

    private getColClass(field: any): string {
        if (field.options?.full_width) return 'col-12';
        if (field.options?.col) return `col-md-${field.options.col}`;
        return 'col-md-6';
    }

    private renderField(field: any, value: any): string {
        const type = field.type || field.component || 'text';
        const lowerType = type.toLowerCase();
        console.log('[AlxarafeResource] renderField:', { field: field.field, type, value });
        const tpl = this.config.templates?.[lowerType + '_edit'];

        const colClass = this.getColClass(field);

        if (tpl) {
            let html = tpl;
            html = html.split('{{field}}').join(field.field);
            html = html.split('{{label}}').join(field.label);

            // Attempt to replace standard column class if present in template
            html = html.replace('col-md-6', colClass);

            let safeValue = value !== null && value !== undefined ? value : '';


            // Normailize type check

            if (lowerType === 'date') {
                // Ensure string to match regex
                const strVal = String(safeValue);
                // Extract YYYY-MM-DD
                const match = strVal.match(/(\d{4}-\d{2}-\d{2})/);
                if (match) {
                    safeValue = match[1];
                } else if (safeValue instanceof Date) {
                    // Fallback if value was a Date object (unlikely via JSON but possible in some setups)
                    const y = safeValue.getFullYear();
                    const m = String(safeValue.getMonth() + 1).padStart(2, '0');
                    const d = String(safeValue.getDate()).padStart(2, '0');
                    safeValue = `${y}-${m}-${d}`;
                }
            }
            html = html.split('{{value}}').join(safeValue);

            // Boolean Attributes (required, readonly)
            const boolAttrs = ['required', 'readonly', 'disabled'];
            boolAttrs.forEach(attr => {
                const hasAttr = field[attr] === true || field.options?.[attr] === true;
                html = html.split(`{{${attr}}}`).join(hasAttr ? attr : '');
            });

            // Value Attributes (min, max, step, maxlength)
            const valAttrs = ['min', 'max', 'step', 'maxlength', 'placeholder'];
            valAttrs.forEach(attr => {
                const val = field[attr] ?? field.options?.[attr];
                if (val !== undefined && val !== null) {
                    html = html.split(`{{${attr}}}`).join(`${attr}="${val}"`);
                } else {
                    html = html.split(`{{${attr}}}`).join('');
                }
            });

            // Specific Check for Boolean checked
            if (type === 'boolean') {
                // Check various truthy values
                const isChecked = value === true || value === 1 || value === '1' || value === 'true';
                html = html.split('{{checked}}').join(isChecked ? 'checked' : '');
            } else {
                // Clean up leftover {{checked}} for non-boolean fields just in case
                html = html.split('{{checked}}').join('');
            }

            return html;
        }

        // Select Field
        if (lowerType === 'select') {
            const options = field.options?.values || {};
            let optionsHtml = '<option value="">-- Seleccionar --</option>';
            const safeValue = value !== null && value !== undefined ? value : '';

            // Handle both object {k:v} and array [{id:k, name:v}] formats if needed
            // Standardizing on { value: label } object/map
            if (Array.isArray(options)) {
                // If simple array of strings/numbers
                options.forEach((opt: any) => {
                    const val = typeof opt === 'object' ? opt.id : opt;
                    const lab = typeof opt === 'object' ? (opt.name || opt.label) : opt;
                    const selected = String(val) === String(safeValue) ? 'selected' : '';
                    optionsHtml += `<option value="${val}" ${selected}>${lab}</option>`;
                });
            } else {
                Object.entries(options).forEach(([k, v]) => {
                    const selected = String(k) === String(safeValue) ? 'selected' : '';
                    optionsHtml += `<option value="${k}" ${selected}>${v}</option>`;
                });
            }

            const selectId = `select-${field.field}-${Math.random().toString(36).substr(2, 9)}`;

            // Post-render init hook
            setTimeout(() => {
                if ((window as any).jQuery && (window as any).jQuery().select2) {
                    (window as any).jQuery(`#${selectId}`).select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: '-- Seleccionar --',
                        allowClear: !field.options?.required
                    }).on('change', (e: any) => {
                        // Trigger native change for dirty checking
                        e.target.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                }
            }, 100);

            return `
                <div class="${colClass} mb-3 alxarafe-select2-wrapper">
                    <label class="form-label small fw-bold text-secondary">${field.label}</label>
                    <select class="form-select alx-select2" id="${selectId}" name="${field.field}" 
                        ${field.options?.required ? 'required' : ''} 
                        ${field.options?.disabled ? 'disabled' : ''}>
                        ${optionsHtml}
                    </select>
                </div>
            `;
        }

        // Relation List (HasMany)
        if (lowerType === 'relation_list' || lowerType === 'relationlist') {
            const rows = Array.isArray(value) ? value : [];
            let cols = field.options?.columns || [];

            // Support associative array from PHP (Object in JS)
            if (!Array.isArray(cols) && typeof cols === 'object') {
                cols = Object.entries(cols).map(([k, v]) => ({ field: k, label: v }));
            }

            if (cols.length === 0 && rows.length > 0) {
                // Auto-detect columns from first row if not provided (simple fallback)
                Object.keys(rows[0]).forEach(k => {
                    if (k !== 'id' && k !== 'created_at' && k !== 'updated_at' && k !== 'deleted_at') {
                        cols.push(k);
                    }
                });
            }

            // Start Inline Edit Logic
            const tableId = `relation-table-${field.field}`;

            // Helper to render a single row (edit mode)
            const renderRow = (row: any, index: number) => {
                const cells = cols.map((c: any) => {
                    const f = typeof c === 'string' ? c : c.field;
                    const val = row[f] ?? '';
                    const inputName = `${field.field}[${index}][${f}]`;
                    return `
                        <td class="ps-3 py-2 small">
                            <input type="text" class="form-control form-control-sm" name="${inputName}" value="${val}">
                        </td>
                    `;
                }).join('');

                const idInput = row.id ? `<input type="hidden" name="${field.field}[${index}][id]" value="${row.id}">` : '';

                // Soft Delete (Disable inputs to trigger backend Sync deletion)
                const deleteJs = `
                    const tr = this.closest('tr');
                    const isDel = tr.classList.contains('table-danger');
                    if (isDel) {
                        tr.classList.remove('table-danger', 'text-decoration-line-through');
                        tr.style.opacity = '1';
                        tr.querySelectorAll('input').forEach(i => i.disabled = false);
                        this.className = 'btn btn-sm btn-outline-danger';
                        this.innerHTML = '<i class="fas fa-trash"></i>';
                    } else {
                        tr.classList.add('table-danger', 'text-decoration-line-through');
                        tr.style.opacity = '0.6';
                        tr.querySelectorAll('input').forEach(i => i.disabled = true);
                        this.className = 'btn btn-sm btn-outline-secondary';
                        this.innerHTML = '<i class="fas fa-undo"></i>';
                    }
                    if(window.alxarafe_unsaved_changes !== undefined) window.alxarafe_unsaved_changes = true;
                `.replace(/\s+/g, ' ');

                const safeDeleteJs = deleteJs.replace(/"/g, '&quot;');

                const deleteBtn = `
                    <td class="text-end pe-3 py-2">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="${safeDeleteJs}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                return `<tr>${cells}${deleteBtn}${idInput}</tr>`;
            };

            const renderBody = () => {
                if (rows.length === 0) {
                    // Start with one empty row? Or message?
                    // Let's return empty and rely on Add button.
                    return '';
                }
                return rows.map((row: any, i: number) => renderRow(row, i)).join('');
            };

            const renderHeader = () => {
                const headers = cols.map((c: any) => {
                    const label = typeof c === 'string' ? (c.charAt(0).toUpperCase() + c.slice(1)) : (c.label || c.field);
                    return `<th class="small text-muted border-0 ps-3">${label}</th>`;
                }).join('');
                // Action column
                return `${headers}<th class="small text-muted border-0 text-end pe-3" style="width: 50px;"></th>`;
            };

            // Expose addRow function globally (hack for inline onclick)
            // Ideally we'd bind events.
            (window as any)[`addRelationRow_${field.field}`] = () => {
                const tbody = document.querySelector(`#${tableId} tbody`);
                if (tbody) {
                    const newIndex = new Date().getTime(); // Simple unique index
                    // Create empty row object based on cols
                    const newRow = {};
                    // Render row (using string, need to ensure correct escaping/context)
                    // Re-use renderRow logic but simpler for JS string injection
                    // Better: Insert HTML directly
                    const html = renderRow({}, newIndex);
                    tbody.insertAdjacentHTML('beforeend', html);
                }
            };

            const createUrl = field.options?.create_url;
            // If create_url exists, use link. If NOT, use inline Add button.
            const addBtn = createUrl ?
                `<a href="${createUrl}" class="btn btn-sm btn-outline-primary float-end" target="_blank"><i class="fas fa-plus"></i> Añadir</a>` :
                `<button type="button" class="btn btn-sm btn-outline-primary float-end" onclick="window['addRelationRow_${field.field}']()"><i class="fas fa-plus"></i> Añadir</button>`;

            // Relation Lists default to full width unless specified
            const relColClass = field.options?.col ? `col-md-${field.options.col}` : 'col-12';

            return `
                <div class="${relColClass} mt-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold text-secondary mb-0">${field.label}</label>
                        ${addBtn}
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="${tableId}">
                                <thead class="bg-light">
                                    <tr>${renderHeader()}</tr>
                                </thead>
                                <tbody>${renderBody()}</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
        }

        // Fallback for text
        return `
            <div class="${colClass}">
                <label class="form-label small fw-bold text-secondary">${field.label}</label>
                <input type="text" class="form-control" name="${field.field}" value="${value}">
            </div>
        `;
    }

    private async handleSave() {
        const form = this.container.querySelector('#alxarafe-edit-form') as HTMLFormElement;
        if (!form) return;

        const btnSave = this.container.querySelector('#btn-save') as HTMLButtonElement;
        const originalBtnHtml = btnSave.innerHTML;
        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

        // Gather Data
        const formData = new FormData(form);
        const data: Record<string, any> = {};

        // Handle standard inputs
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // Handle checkboxes (unchecked checkboxes are not sent by FormData)
        const checkBoxes = form.querySelectorAll('input[type="checkbox"]');
        checkBoxes.forEach((cb: any) => {
            data[cb.name] = cb.checked;
        });

        const url = new URL(window.location.href);
        url.searchParams.set('ajax', 'save_record');
        // Ensure id is passed if we are editing 'new' or existing
        if (this.config.recordId) {
            url.searchParams.set('id', String(this.config.recordId));
        }

        try {
            // Send as JSON
            const payload: any = { data: {} };
            for (const [key, val] of Object.entries(data)) {
                payload.data[key] = val;
            }

            const response = await fetch(url.toString(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.status === 'error' || result.error) {
                let msg = result.error || 'Unknown error';
                if (result.errors && Array.isArray(result.errors)) {
                    msg = result.errors.join('<br>');
                }
                throw new Error(msg);
            }

            // Update Form Data if returned
            if (result.status === 'success') {
                this.showMessage(result.message || 'Guardado correctamente', 'success');
                (window as any).alxarafe_unsaved_changes = false; // Reset flag on success

                if (result.data) {
                    this.updateFormFields(form, result.data);
                }

                if (this.config.recordId === 'new' && result.id) {
                    // Redirect to edit mode for the new ID to reload properly
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('id', result.id);
                    window.location.href = newUrl.toString();
                }
            }


            // Restore button
            btnSave.disabled = false;
            btnSave.innerHTML = originalBtnHtml;

        } catch (error: any) {
            this.showMessage(`Error al guardar: ${error.message}`, 'danger');
            btnSave.disabled = false;
            btnSave.innerHTML = originalBtnHtml;
        }
    }

    private updateFormFields(form: HTMLFormElement, data: Record<string, any>) {
        Object.entries(data).forEach(([key, val]) => {
            const input = form.querySelector(`[name="${key}"]`) as HTMLInputElement;
            if (input) {
                if (input.type === 'checkbox') {
                    const isChecked = Boolean(val) && String(val) !== '0';
                    input.checked = isChecked;
                } else {
                    input.value = val;
                }
            }
        });
    }

}