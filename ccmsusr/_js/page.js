import {PickleTree} from '/ccmsusr/_js/pickle.js';


export class Page{
    constructor(){
        this.buildTree();
        this.setEvents();
    }

    buildTree(){
        const elm = document.getElementById('txt_log');
        this.sideElm = [{
            icon:'fa fa-plus',
            title:'Add Child',
            //context button click event
            onClick : async (node) => {
                //console.log('add - '+node.id);
                const { value: title } = await Swal.fire({
                    title: 'Enter Child Name..',
                    input: 'text',
                    showCancelButton: true,
                    inputValidator: (value) => {
                      if (!value) {
                        return 'You need to write something!'
                      }
                    }
                });
                const id = (new Date()).getTime();
                //add new child element
                this.tree.createNode({
                    n_value: id,
                    n_title: title,
                    n_id: id,
                    n_elements : this.sideElm,
                    n_parent: this.tree.getNode(node.value),
                    n_checkStatus: false
                });
            }
        },{
            icon:'fa fa-edit',
            title:'Edit',
            //context button click event
            onClick : async(node) => {
                //console.log('edit - '+node.id);
                const { value: title } = await Swal.fire({
                    title: 'Enter Child Name..',
                    input: 'text',
                    inputValue:node.title,
                    showCancelButton: true,
                    inputValidator: (value) => {
                      if (!value) {
                        return 'You need to write something!'
                      }
                    }
                });
                node.title = title;
                node.updateNode();
            }
        },{
            icon:'fa fa-trash',
            title:'Delete',
            onClick : (node) => {
                console.log('delete - '+node.id);
                node.deleteNode();
            }
        }];
        this.tree = new PickleTree({
            c_target: 'div_tree',
            rowCreateCallback: (node) => {
                elm.value += node.title +' => element added..\n';
                elm.scrollTop = elm.scrollHeight;
                //console.log(node)
            },
            switchCallback: (node) => {
                elm.value += node.title +' => element switched..\n';
                elm.scrollTop = elm.scrollHeight;
                //console.log(node)
            },
            drawCallback: () => {
                //console.log('tree drawed ..');
            },
            dragCallback: (node) => {
                //console.log(node);
            },
            dropCallback: (node) => {
                //retuns node with new parent and old parent in 'old_parent' key!!
                elm.value += node.title +' => element dragged..\n';
                elm.scrollTop = elm.scrollHeight;
                //console.log(node);
            },
            nodeRemoveCallback:(node)=>{
                //returns removed node
                //console.log(node);
                elm.value += node.title +' => element removed..\n';
                elm.scrollTop = elm.scrollHeight;
            },
            c_config: {
                //start as folded or unfolded
                foldedStatus: false,
                //for logging
                logMode: false,
                //for switch element
                switchMode: true,
                //for automaticly select childs
                autoChild :true,
                //for automaticly select parents
                autoParent : true,
                //for drag / drop
                drag: true
            },
            c_data: [{
                n_id: 1,
                n_title: 'falan1',
                n_parentid: 0,
                n_checkStatus: true,
                n_elements : this.sideElm,
            }, {
                n_id: 2,
                n_title: 'falan2',
                n_parentid: 0,
                n_elements : this.sideElm,
            }, {
                n_id: 3,
                n_title: 'falan3',
                n_parentid: 0,
                n_elements : this.sideElm,
            }, {
                n_id: 4,
                n_title: 'falan1-1',
                n_parentid: 1,
                n_elements : this.sideElm,
            }, {
                n_id: 5,
                n_title: 'falan1-2',
                n_parentid: 1,
                n_elements : this.sideElm,
            }, {
                n_id: 10,
                n_title: 'falan1-2-1',
                n_parentid: 5,
                n_elements : this.sideElm,
            }]
        });
    }

    setEvents(){
        const log = document.getElementById('txt_log');
        const input = document.getElementById('in_item');
        const button = document.getElementById('btn_add');
        const buttonSelected = document.getElementById('btn_getSelected');

        button.addEventListener('click',e=>{
            if(input.value.trim()===''){
                input.classList.add('is-invalid');
            }else{
                const id = (new Date()).getTime();
                this.tree.createNode({
                    n_value: id,
                    n_title: input.value,
                    n_id: id,
                    n_elements : this.sideElm,
                    n_parent: {id:0},
                    n_checkStatus: false
                });
            }

            input.value = '';

        });

        buttonSelected.addEventListener('click',e=>{
            log.value += 'Selected Items => '+JSON.stringify(this.tree.getSelected())+'\n';
            log.scrollTop = log.scrollHeight;
        });

        input.addEventListener('keydown',e=>{
            if ( e.keyCode == 13 ) {
                button.click();
            }
        });

    }
}
