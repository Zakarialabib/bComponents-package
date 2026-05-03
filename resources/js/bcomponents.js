import Alpine from 'alpinejs'
import flatpickr from 'flatpickr'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

if (!window.Alpine) {
    window.Alpine = Alpine
    Alpine.start()
}

window.flatpickr = window.flatpickr || flatpickr
window.ClassicEditor = window.ClassicEditor || ClassicEditor

Alpine.data('bOverlay', (opts = {}) => ({
    show: !!opts.initialOpen,
    static: !!opts.static,
    focusables() {
        const selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...this.$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    open() { this.show = true },
    close() { if (!this.static) this.show = false },
    toggle() { this.show ? this.close() : this.open() },
    init() {
        this.$watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden')
                setTimeout(() => this.firstFocusable()?.focus(), 50)
            } else {
                document.body.classList.remove('overflow-y-hidden')
            }
        })
    },
}))

Alpine.data('bDropdown', (opts = {}) => ({
    open: !!opts.initialOpen,
    name: opts.name ?? null,
    toggle() { this.open = !this.open },
    close() { this.open = false },
    openNamed(name) { if (this.name && this.name === name) this.open = true },
    closeNamed(name) { if (this.name && this.name === name) this.open = false },
}))

Alpine.data('bToast', (opts = {}) => ({
    open: true,
    duration: Number(opts.duration || 5000),
    dismissible: opts.dismissible !== false,
    timer: null,
    startTimer() {
        if (!this.duration) return
        this.stopTimer()
        this.timer = setTimeout(() => { this.open = false }, this.duration)
    },
    stopTimer() {
        if (this.timer) clearTimeout(this.timer)
        this.timer = null
    },
    close() { if (this.dismissible) this.open = false },
    init() { this.startTimer() },
}))

Alpine.data('bTabs', (opts = {}) => ({
    active: opts.initial ?? null,
    setActive(value) { this.active = value },
    tabs() {
        return [...this.$el.querySelectorAll('[role=\"tab\"]')].filter(el => !el.hasAttribute('disabled'))
    },
    focusTab(index) {
        const tabs = this.tabs()
        const clamped = ((index % tabs.length) + tabs.length) % tabs.length
        tabs[clamped]?.focus()
    },
    focusNext(currentEl) {
        const tabs = this.tabs()
        const idx = tabs.indexOf(currentEl)
        this.focusTab(idx + 1)
    },
    focusPrev(currentEl) {
        const tabs = this.tabs()
        const idx = tabs.indexOf(currentEl)
        this.focusTab(idx - 1)
    },
    onKeydown(e) {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
            e.preventDefault()
            this.focusNext(e.currentTarget)
        }
        if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
            e.preventDefault()
            this.focusPrev(e.currentTarget)
        }
        if (e.key === 'Home') {
            e.preventDefault()
            this.focusTab(0)
        }
        if (e.key === 'End') {
            e.preventDefault()
            this.focusTab(this.tabs().length - 1)
        }
    },
}))
