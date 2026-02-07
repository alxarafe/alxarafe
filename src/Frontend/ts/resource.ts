export interface StructConfig {
    mode: 'list' | 'edit';
    recordId?: string | number;
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
        }
        this.injectStyles();
    }

    private injectStyles() {
        const styleId = 'alxarafe-resource-styles';
        if (document.getElementById(styleId)) return;

        const style = document.createElement('style');
        style.id = styleId;
        style.innerHTML = `
            /* Scoped Select2 Fixes for Alxarafe Resource */
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 {
                font-size: 0.875rem !important;
            }
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection {
                font-size: 0.875rem !important;
                min-height: calc(1.5em + 0.5rem + 2px) !important;
                padding: 0.25rem 0.5rem !important;
            }
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection__rendered {
                font-size: 0.875rem !important;
                line-height: 1.5 !important;
                color: #212529 !important;
            }
            .alxarafe-select2-wrapper .select2-container--bootstrap-5 .select2-selection__placeholder {
                font-size: 0.875rem !important;
                line-height: 1.5 !important;
            }
            /* Fix Dropdown too */
            .select2-container--bootstrap-5 .select2-dropdown .select2-results__option {
                font-size: 0.875rem !important;
                padding: 0.25rem 0.75rem !important;
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

        if (this.config.templates && this.config.templates['layout_list']) {
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

        } else {
            this.container.innerHTML = `
                <div class="alxarafe-resource-list animate__animated animate__fadeIn">
                    
                    <!-- Tabs Navigation (if multiple) -->
                    ${this.renderTabsNav()}

                    <!-- Action Toolbar: Left and Right Groups -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group">
                            <!-- Left Buttons -->
                            ${leftButtons.map(renderBtn).join('')}
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Right Buttons -->
                            ${rightButtons.map(renderBtn).join('')}
                        </div>
                    </div>

                    <!-- Collapsible Filters Panel (Default Open) -->
                    <div class="card border mb-3 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
                             style="cursor: pointer;"
                             data-bs-toggle="collapse" 
                             data-bs-target="#alxarafe-filters-collapse" 
                             aria-expanded="true">
                            <h6 class="mb-0 text-primary"><i class="fas fa-search me-2"></i>Filtros de búsqueda</h6>
                            <i class="fas fa-chevron-up text-muted"></i>
                        </div>
                        <div class="collapse show" id="alxarafe-filters-collapse">
                            <div class="card-body bg-light">
                                <div class="row g-2" id="alxarafe-filters-row">
                                    <!-- Filters injected here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <!-- Added table-striped for "pijama" effect -->
                                <table class="table table-striped table-hover align-middle mb-0" id="alxarafe-table">
                                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                                        <tr>
                                            ${currentTab.columns.map((col: any) => `
                                                <th class="py-3 px-4 border-0">${col.label}</th>
                                            `).join('')}
                                            <th class="text-end py-3 px-4 border-0" style="width: 120px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="alxarafe-table-body" class="border-top-0">
                                       <!-- Rows injected here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 py-3 px-4" id="alxarafe-pagination">
                            <!-- Pagination injected here -->
                        </div>
                    </div>
                </div>
            `;
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
                    <td class="px-4 py-3 text-secondary">${this.formatValue(row[col.field], col)}</td>
                `).join('')}
                <td class="text-end px-4 py-3">
                    <a href="?${this.getRoutingParams()}&id=${row.id ?? row.code}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Editar">
                        <i class="fas fa-pen small"></i>
                    </a>
                </td>
            </tr>
        `).join('');
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

        // Logic for sliding window: [1] ... [current-2] [current-1] [current] [current+1] [current+2] ... [last]
        let pagesParams: (number | string)[] = [];

        if (totalPages <= 7) {
            // Show all if few
            for (let i = 1; i <= totalPages; i++) pagesParams.push(i);
        } else {
            // Always show 1
            pagesParams.push(1);
            if (currentPage > 3) pagesParams.push('...');

            // Neighbors
            for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                pagesParams.push(i);
            }

            if (currentPage < totalPages - 2) pagesParams.push('...');
            // Always show last
            pagesParams.push(totalPages);
        }

        container.innerHTML = `
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted small mb-2 mb-md-0">
                    Mostrando ${start} - ${end} de ${total} registros
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        ${buildPageItem(currentPage - 1, '<i class="fas fa-chevron-left"></i>', currentPage === 1)}
                        ${pagesParams.map(p => {
            if (p === '...') return '<li class="page-item disabled"><span class="page-link">...</span></li>';
            return buildPageItem(p, String(p), false, p === currentPage);
        }).join('')}
                        ${buildPageItem(currentPage + 1, '<i class="fas fa-chevron-right"></i>', currentPage === totalPages)}
                    </ul>
                </nav>
            </div>
        `;

        // Bind Events
        container.querySelectorAll('button[data-page]:not([disabled])').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const target = e.target as HTMLElement;
                // Handle icon clicks
                const btnEl = target.closest('button');
                if (!btnEl || !btnEl.dataset.page) return;

                const targetPage = parseInt(btnEl.dataset.page);

                // Calculate new offset
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

    private formatValue(value: any, col: any): string {
        if (typeof col === 'string') {
            col = { type: col };
        }

        const type = col.component || col.type || 'text';

        // Try generic template first
        const tpl = this.config.templates?.[type.toLowerCase() + '_list'];
        if (tpl) {
            let html = tpl;
            const safeValue = value !== null && value !== undefined ? value : '';
            html = html.split('{{value}}').join(safeValue);

            // Boolean check for checked property if needed in list
            if (type === 'boolean') {
                const isChecked = Boolean(value) && String(value) !== '0';
                html = html.split('{{checked}}').join(isChecked ? 'checked' : '');
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

        if (col.type === 'boolean' || col.component === 'boolean') {
            const isChecked = Boolean(value) && String(value) !== '0';
            return `<div class="text-center"><input type="checkbox" class="form-check-input" ${isChecked ? 'checked' : ''} disabled></div>`;
        }

        if (col.type === 'date' || col.type === 'date_expiration') {
            if (!value) return '';
            const displayDate = value.split('T')[0].split('-').reverse().join('-');

            // Logic for alerts (omitted for brevity if template handles it, keeping legacy support)
            // Alert / Coloring Logic
            const alerts = col.alerts || [];

            // Backward compatibility for date_expiration simple config (simulate alerts)
            if (col.type === 'date_expiration' && alerts.length === 0) {
                const warningDays = col.warning_days !== undefined ? parseInt(col.warning_days) : 30;
                const dangerDays = col.danger_days !== undefined ? parseInt(col.danger_days) : 15;
                alerts.push({ days: 0, class: 'text-danger' }); // Expired
                alerts.push({ days: dangerDays, class: 'text-danger' });
                alerts.push({ days: warningDays, class: 'text-warning' });
            }

            if (alerts.length > 0) {
                const isoDate = value.split('T')[0];
                const date = new Date(isoDate);
                const now = new Date();
                now.setHours(0, 0, 0, 0);

                const diffTime = date.getTime() - now.getTime();
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                let activeClass = '';
                for (const rule of alerts) {
                    if (diffDays < rule.days) {
                        activeClass = rule.class;
                        break;
                    }
                }

                if (!activeClass && col.type === 'date_expiration') activeClass = 'text-success';

                if (activeClass) {
                    return `<span class="${activeClass}">${displayDate}</span>`;
                }
            }
            return displayDate;
        }

        if (col.type === 'datetime') {
            return value.replace('T', ' ').substring(0, 16);
        }

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
            this.container.innerHTML = `
                <div class="alxarafe-resource-edit animate__animated animate__fadeIn">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-edit text-primary me-2"></i>Editar Registro
                        </h3>
                        <div class="actions">
                            <button class="btn btn-outline-secondary me-2" onclick="history.back()">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </button>
                            <button class="btn btn-success shadow-sm" id="btn-save">
                                <i class="fas fa-save me-1"></i> Guardar
                            </button>
                        </div>
                    </div>

                    <div id="edit-form-container">
                        <div class="text-center p-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Cargando datos...</p>
                        </div>
                    </div>
                </div>
            `;
        }

        this.loadRecordData();
        this.setupAlertHelper();

        this.container.querySelector('#btn-save')?.addEventListener('click', () => this.handleSave());
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
    }

    private renderField(field: any, value: any): string {
        const type = field.type || field.component || 'text';
        const tpl = this.config.templates?.[type.toLowerCase() + '_edit'];

        if (tpl) {
            let html = tpl;
            html = html.split('{{field}}').join(field.field);
            html = html.split('{{label}}').join(field.label);
            html = html.split('{{value}}').join(value !== null && value !== undefined ? value : '');

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
                const isChecked = Boolean(value) && String(value) !== '0';
                html = html.split('{{checked}}').join(isChecked ? 'checked' : '');
            }

            return html;
        }

        // Fallback for text
        return `
            <div class="col-md-6">
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

            this.showMessage('Guardado correctamente', 'success');

            // Update Form Data if returned
            if (result.data) {
                this.updateFormFields(form, result.data);
            }

            if (this.config.recordId === 'new' && result.id) {
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('id', result.id);
                window.location.href = newUrl.toString();
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