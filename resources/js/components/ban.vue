<template>
<div>
    <button type="button" @click.prevent="show" class="btn btn-success">Modal</button>
    <modal name="modal-step" width="600"  height="auto" classes="demo-modal-class">
        <div class="modal-content">
            
              
                <div class="form-group">
                    <label>BAN</label>
                            

                </div>
            
            <button class="btn btn-primary" >Submit</button>
            
        </div>
    </modal>
</div>
</template>


<script>
import axios from "axios";
import _ from 'lodash';
export default {

    methods:{


        show () {
                this.$modal.show('modal-step');
            },
        hide () {
                this.$modal.hide('modal-step');
            }

    }

}
</script>

<style>
.demo-modal-class {
    border-radius: 5px;
    background: #F7F7F7;
    box-shadow: 5px 5px 30px 0px rgba(46,61,73, 0.6);
}
.modal-content {
    height: 100%;
    box-sizing: border-box;
    padding: 10px;
    font-size: 13px;
    overflow: auto;
}

</style>