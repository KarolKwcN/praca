<template>
<div class="container">

    <button type="button" @click.prevent="show" class="btn btn-success">Dodaj krok</button>

    <div class="py-5 text-center">
        <div class="container">
            <div class="row">
                 <div class="col-lg-6 col-8 order-2 order-lg-1">
           <hooper  style="height: 400px"  :centerMode="true">
  <slide>
     <div class="images">
    
   <a href="/images/1/Wymiana baterii/17509935071588705882.jpg"> <img   class="img-fluid d-block" src="/images/1/Wymiana baterii/17509935071588705882.jpg"></a>
     </div>
  </slide>
  <slide>
   <img  class="img-fluid d-block" src="/images/1/Wymiana baterii/4969974321588705882.jpg">
  </slide>
  <slide>
   <img   class="img-fluid d-block" src="/images/1/hjhgjhgjhgj/2860053041588705542.jpg">
  </slide>
  <slide>
    <h2>4</h2>
  </slide>
  <slide>
    <h2>5</h2>
  </slide>
  <slide>
    <h2>6</h2>
  </slide>
  <hooper-navigation slot="hooper-addons"></hooper-navigation>
</hooper>
                 </div>
                <div class="px-md-5 p-3 d-flex flex-column justify-content-center col-lg-6 order-1 order-lg-3">
                    <h1>O my friend</h1>
                    <p class="lead">I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms of the insects and flies</p>
                </div>
            </div>
        </div>
    </div>

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
                        <vue-editor v-model="description"></vue-editor>
                    </div>
                    <button class="btn btn-primary" @click="uploadFile">Submit</button>
                </div>
            </div>
        </div>
    </modal>
</div>
</template>

<script>
import { Hooper, Slide,  Navigation as HooperNavigation } from 'hooper';
import 'hooper/dist/hooper.css';
import axios from "axios";
import {
    VueEditor
} from "vue2-editor";
export default {

    props: ['repair'],
    name: "MultipleUpload",

    components: {
        VueEditor,
        Hooper,
    Slide,
    HooperNavigation
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
            axios.post('/api/serwisant/naprawa/step/' + this.repair, this.form, config).then(response => {
                    //success
                    console.log(response);
                    this.$modal.hide("modal-step");
                })
                .catch(response => {
                    //error
                });

            this.name = "";
            this.description = "";
            this.attachments = "";
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
.images {
    max-width:100%;
  height: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
}
</style>
