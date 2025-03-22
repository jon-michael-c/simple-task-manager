import './bootstrap';
import Sortable from 'sortablejs';

/**
 * Configuration for Sortable.js
 */
const SORTABLE_CONFIG = {
    animation: 150,
    ghostClass: 'sortable-ghost',
    dragClass: 'sortable-drag',
    handle: '[wire\\:sortable\\.handle]'
};

/**
 * Initialize Sortable.js for a given element
 * @param {HTMLElement} element - The element to make sortable
 */
function createSortableInstance(element) {
    const component = window.Livewire.find(
        element.closest('[wire\\:id]')?.getAttribute('wire:id')
    );

    if (!component) return;

    const method = element.getAttribute('wire:sortable');

    Sortable.create(element, {
        ...SORTABLE_CONFIG,
        onEnd: () => {
            const items = [...element.querySelectorAll('[wire\\:sortable\\.item]')]
                .map(item => item.getAttribute('wire:sortable.item'));
            component.call(method, items);
        }
    });

    // Mark as initialized
    element.classList.add('sortable-initialized');
}

/**
 * Initialize Sortable.js for all sortable elements
 */
function initializeSortable() {
    document.querySelectorAll('[wire\\:sortable]').forEach(element => {
        // Skip if already initialized
        if (!element.classList.contains('sortable-initialized')) {
            createSortableInstance(element);
        }
    });
}

// Initialize when Livewire is ready
document.addEventListener('livewire:initialized', initializeSortable);

// Re-initialize when Livewire updates the DOM
document.addEventListener('livewire:navigated', initializeSortable);
