(function () {
    'use strict';

    var sidebar = document.getElementById('modern-sidebar');
    if (!sidebar) return;

    var body = document.body;
    var breakpoint = window.matchMedia('(min-width: 1200px)');
    var lastFocusedElement = null;
    var storageKey = 'ui.sidebar.v1';
    var toggle = document.querySelector('[data-modern-sidebar-toggle]');
    var close = sidebar.querySelector('[data-modern-sidebar-close]');
    var collapse = sidebar.querySelector('[data-modern-sidebar-collapse]');
    var backdrop = document.querySelector('[data-modern-sidebar-backdrop]');
    var search = sidebar.querySelector('[data-modern-sidebar-search]');

    function desktop() { return breakpoint.matches; }
    function setToggleLabel(open) {
        if (!toggle) return;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Cerrar menú lateral' : 'Abrir menú lateral');
    }
    function openDrawer() {
        if (desktop()) return;
        lastFocusedElement = document.activeElement;
        body.classList.add('modern-sidebar-drawer-open');
        setToggleLabel(true);
        window.setTimeout(function () { (close || search).focus(); }, 0);
    }
    function closeDrawer() {
        body.classList.remove('modern-sidebar-drawer-open');
        setToggleLabel(false);
        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') lastFocusedElement.focus();
    }
    function setCollapsed(collapsed) {
        if (!desktop()) return;
        body.classList.toggle('modern-sidebar-collapsed', collapsed);
        collapse.setAttribute('aria-pressed', collapsed ? 'true' : 'false');
        collapse.setAttribute('aria-label', collapsed ? 'Expandir menú lateral' : 'Contraer menú lateral');
        collapse.querySelector('i').className = collapsed ? 'fas fa-expand-alt' : 'fas fa-compress-alt';
        try { localStorage.setItem(storageKey, collapsed ? 'collapsed' : 'expanded'); } catch (error) {}
    }
    function restorePreference() {
        if (!desktop()) return;
        try { setCollapsed(localStorage.getItem(storageKey) === 'collapsed'); } catch (error) {}
    }
    function closeOnBreakpoint() {
        if (desktop()) closeDrawer();
        else body.classList.remove('modern-sidebar-collapsed');
        restorePreference();
    }

    if (toggle) toggle.addEventListener('click', function (event) {
        event.preventDefault();
        if (desktop()) setCollapsed(!body.classList.contains('modern-sidebar-collapsed'));
        else if (body.classList.contains('modern-sidebar-drawer-open')) closeDrawer(); else openDrawer();
    });
    if (collapse) collapse.addEventListener('click', function () { setCollapsed(!body.classList.contains('modern-sidebar-collapsed')); });
    if (close) close.addEventListener('click', closeDrawer);
    if (backdrop) backdrop.addEventListener('click', closeDrawer);

    sidebar.querySelectorAll('[data-modern-submenu-button]').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('[data-modern-menu-parent]');
            var open = !parent.classList.contains('is-open');
            parent.classList.toggle('is-open', open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    sidebar.querySelectorAll('a[href]').forEach(function (link) {
        link.addEventListener('click', function () { if (!desktop()) closeDrawer(); });
    });

    function filterMenu() {
        var term = (search.value || '').trim().toLocaleLowerCase('es');
        var matches = 0;
        sidebar.querySelectorAll('[data-modern-menu-item]').forEach(function (item) {
            var link = item.querySelector('[data-search]');
            var match = !term || (link && link.dataset.search.indexOf(term) !== -1);
            item.hidden = !match;
            if (match) matches++;
        });
        sidebar.querySelectorAll('[data-modern-menu-parent]').forEach(function (parent) {
            var button = parent.querySelector('[data-modern-submenu-button]');
            var selfMatch = !term || button.dataset.search.indexOf(term) !== -1;
            if (term && selfMatch) {
                parent.querySelectorAll('[data-modern-menu-item]').forEach(function (item) { item.hidden = false; });
                matches++;
            }
            var childMatch = Array.prototype.some.call(parent.querySelectorAll('[data-modern-menu-item]'), function (item) { return !item.hidden; });
            parent.hidden = !selfMatch && !childMatch;
            if (term && childMatch) {
                parent.classList.add('is-open');
                button.setAttribute('aria-expanded', 'true');
            }
        });
        sidebar.querySelectorAll('[data-modern-menu-section]').forEach(function (section) {
            section.hidden = !Array.prototype.some.call(section.querySelectorAll('li'), function (item) { return !item.hidden; });
        });
        sidebar.querySelector('[data-modern-sidebar-empty]').hidden = matches > 0;
    }
    if (search) {
        search.addEventListener('input', filterMenu);
        document.addEventListener('keydown', function (event) {
            if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                if (desktop() && body.classList.contains('modern-sidebar-collapsed')) setCollapsed(false);
                if (!desktop()) openDrawer();
                search.focus();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && body.classList.contains('modern-sidebar-drawer-open')) closeDrawer();
        if (event.key !== 'Tab' || desktop() || !body.classList.contains('modern-sidebar-drawer-open')) return;
        var focusable = sidebar.querySelectorAll('a[href], button:not([disabled]), input:not([disabled])');
        var visible = Array.prototype.filter.call(focusable, function (element) {
            return !element.closest('[hidden]') && element.getClientRects().length > 0;
        });
        if (!visible.length) return;
        if (event.shiftKey && document.activeElement === visible[0]) { event.preventDefault(); visible[visible.length - 1].focus(); }
        else if (!event.shiftKey && document.activeElement === visible[visible.length - 1]) { event.preventDefault(); visible[0].focus(); }
    });

    if (breakpoint.addEventListener) breakpoint.addEventListener('change', closeOnBreakpoint);
    else breakpoint.addListener(closeOnBreakpoint);
    restorePreference();
}());
