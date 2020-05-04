<template>
<div class="container">
    <button type="button" @click.prevent="show" class="btn btn-success">Dodaj krok</button>
    <modal name="modal-step" height="auto" classes="demo-modal-class">
        <div id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" v-model="name" name="name" id="name" placeholder="Nazwa kroku">
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input id="upload-file" type="file" accept="image/*" multiple class="form-control" style="display: none;" @change="fieldChange">
                                <input type="button" value="Browse..." onclick="document.getElementById('upload-file').click();" />
                            </div>
                            <div class="field">
                                <div v-for="(file, index) in attachments" :key="index" :class="`level ${file.invalidMessage && 'text-danger'}`">
                                    <div class="level-left">
                                        <div class="level-item">
                                            {{file.name}}
                                            <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>
                                        </div>
                                    </div>
                                    <div class="level-right">
                                        <div class="level-item">
                                            <a @click.prevent="attachments.splice(index, 1);uploadFiles.splice(index, 1)" class="delete">x</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <vue-editor  v-model="description"></vue-editor>
                    </div>
                    <button class="btn btn-primary" @click="uploadFile">Submit</button>
                </div>
            </div>
        </div>
    </modal>
</div>
</template>

<script>
import axios from "axios";
import {
    VueEditor
} from "vue2-editor";
export default {

     props: ['repair'],
    name: "MultipleUpload",

    components: {
        VueEditor
    },

    data() {
        return {
            name: '',
            description: '',
            uploadFiles: [],
            attachments: [],
            form: new FormData

        }
    },

    methods: {
        fieldChange(e) {
            let selectedFiles = e.target.files;
            if (!selectedFiles.length) {
                return false;
            }
            for (let i = 0; i < selectedFiles.length; i++) {
                this.attachments.push(selectedFiles[i]);
            }
            console.log(this.attachments);
        },
        selectFile() {
            const attachments = this.$refs.attachments.attachments;
            this.uploadFiles = [...this.uploadFiles, ...attachments];

        },
        uploadFile() {

            for (let i = 0; i < this.attachments.length; i++) {
                this.form.append('pics[]', this.attachments[i]);
            }
            this.form.append('name', this.name);
            this.form.append('description', this.description);
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };
            document.getElementById('upload-file').value = [];
            axios.post('/api/serwisant/naprawa/step/'+ this.repair, this.form, config).then(response => {
                    //success
                    console.log(response);
                })
                .catch(response => {
                    //error
                });
        },

        show() {
            this.$modal.show('modal-step');
        },
        hide() {
            this.$modal.hide('modal-step');
        }
    }

}
</script>

<style>
</style>
