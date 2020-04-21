<template>
<div>
    <button @click.prevent="show" type="button" class="btn btn-success">Nowa naprawa</button>
    <div>
        <modal name="modal-step" height="auto" classes="demo-modal-class">
            <div id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nowa naprawa</h5>

                            <button @click.prevent="hide" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/api/serwisant/addRepair" enctype="multipart/form-data" @submit="addRepair">

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nazwa:</label>
                                    <input type="text" v-model="name" name="name" class="form-control" id="recipient-name" />
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Opis:</label>
                                    <textarea v-model="description" class="form-control" id="recipient-description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                                    <div class="col-md-4">
                                        <input v-on:change="onImageChange" id="upload-file" name="zdj" class="input-file" type="file">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click.prevent="hide" type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                <input type="submit" value="Zmień" class="btn btn-primary" />

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</div>
</template>

<script>
import Vue from "vue";
import Form from "vform";
export default {
    props: ['device'],
    data() {
        return {
            image: "",
            editmode: false,
            repairs: {},
            name: "",
            description: "",

        }

    },
    methods: {
        addRepair(e) {

            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.name);
            formData.append('description', this.description);

        
            axios.post("/api/serwisant/addRepair/" + this.device, formData, config).then(function (response) {
                currentObj.success = response.data.success;
            }).catch(function (error) {
                currentObj.output = error;
            });
        },
        onImageChange(e) {
            console.log(e.target.files[0]);
            this.image = e.target.files[0];
        },
        show() {
            this.$modal.show("modal-step");
        },
        hide() {
            this.$modal.hide("modal-step");
        },
    }
}
</script>

<style>

</style>
