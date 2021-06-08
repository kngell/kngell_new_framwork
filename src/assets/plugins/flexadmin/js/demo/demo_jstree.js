import 'jstree/dist/jstree.min';
import 'jstree/dist/themes/default/style.min.css';

class DemoJstree {
    constructor() {}

    init() {
        this.tree_1();
    }

    tree_1() {
        $("#demo-tree-1").jstree({
            "core": {
                "themes": {
                    "responsive": false
                },
                "check_callback": true,
                'data': [{
                        "text": "Folder 1",
                        "children": [{
                            "text": "Products",
                            "state": {
                                "selected": true
                            }
                        }, {
                            "text": "Custom Icon",
                            "icon": "fab fa-react text-info"
                        }, {
                            "text": "Your pictures",
                            "icon": "fal fa-star text-warning"
                        }, {
                            "text": "Disabled Node",
                            "icon": "fal fa-ban text-danger",
                            "state": {
                                "disabled": true
                            }
                        }, {
                            "text": "Other Product",
                            "icon": "fa fa-folder",
                            "children": [
                                { "text": "Screenshot 1", "icon": "fad fa-file-alt text-warning" },
                                { "text": "Screenshot 2", "icon": "fad fa-file-alt text-success" },
                                { "text": "Screenshot 3", "icon": "fad fa-file-alt text-default" },
                                { "text": "Screenshot 4", "icon": "fad fa-file-alt text-danger" },
                                { "text": "Screenshot 5", "icon": "fad fa-file-alt text-info" }
                            ]
                        }, {
                            "text": "Projects",
                            "icon": "fa fa-folder text-success",
                            "state": {
                                "opened": true
                            },
                            "children": [
                                { "text": "Another node" }
                            ]
                        }]
                    },
                    "Folder 2"
                ]
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-info"
                },
                "file": {
                    "icon": "far fa-file-image text-success"
                }
            },
            "state": { "key": "demo2" },
            "plugins": ["dnd", "state", "types", "contextmenu"]
        });

    }
}

export default DemoJstree;
new DemoJstree().init()
