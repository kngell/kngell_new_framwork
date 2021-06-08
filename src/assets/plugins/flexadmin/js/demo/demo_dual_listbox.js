import DualListbox from 'dual-listbox/src/dual-listbox.js';

class DemoDualListbox {
    constructor() {}

    init() {
        let select = document.querySelector('#dual-listbox-demo');
        if (!select) return false;
        var dualListBox = new DualListbox(select, {
            addEvent: function(value) { // Should use the event listeners
            },
            removeEvent: function(value) { // Should use the event listeners
            },
            availableTitle: 'Available items',
            selectedTitle: 'Selected items',
            addButtonText: '<i class="far fa-chevron-right"></i>',
            removeButtonText: '<i class="far fa-chevron-left"></i>',
            addAllButtonText: '<i class="far fa-chevron-double-right"></i>',
            removeAllButtonText: '<i class="far fa-chevron-double-left"></i>'
        });

        dualListBox.search.remove();

    }
}

new DemoDualListbox().init()
