<template>
<div>

    <div class="row">
        <div class="col-lg-12">
            <div class="float-right">
                <button @click.prevent="show" type="button" class="btn btn-success">Nowa naprawa</button>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>Id.</th>
                        <th>Nazwa</th>
                        <th>Użytkownik</th>
                        <th>Status realizacji</th>
                        <th>Zaakceptowane</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="repair in repairs" :key="repair.id" class="text-center">
                        <td>{{repair.id}}</td>
                        <td>
                            <a :href="`/serwisant/naprawa/`+device+`/`+repair.slugi_repair">
                                {{repair.name}}
                            </a>
                        </td>
                        <td>
                            {{repair.users.name}}
                        <td>
                            {{repair.status}}
                        </td>
                        <td>
                            {{repair.accept}}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="card-footer">

            </div>
            <div class="col-12 d-flex justify-content-center"></div>
        </div>
    </div>
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

                                    <p class="text-danger" v-if="!$v.name.minLength">Nazwa powinna zawierać minimum 4 znaki!</p>
                                    <div class="invalide-feedback text-danger">
                                        {{errors.get('name')}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Opis:</label>
                                    <textarea v-model="description" class="form-control" id="recipient-description"></textarea>
                                    <div class="invalide-feedback text-danger">
                                        {{errors.get('description')}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="filebutton">Wybierz zdjęcie:</label>
                                    <div class="col-md-4">
                                        <input v-on:change="onImageChange" id="upload-file" name="zdj" class="input-file" type="file">
                                    </div>
                                    <div class="invalide-feedback text-danger">
                                        {{errors.get('image')}}
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click.prevent="hide" type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                <input type="submit" value="Dodaj" class="btn btn-primary" />

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
class Errors {
    constructor() {
        this.errors = {};
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    record(errors) {
        this.errors = errors.errors;
    }
}

import Vue from "vue";
import Form from "vform";
import {
    required,
    minLength
} from 'vuelidate/lib/validators'
export default {
    props: ['device'],
    data() {
        return {
            image: "",
            editmode: false,
            repairs: {},
            name: "",
            description: "",
            errors: new Errors()

        }

    },
    validations: {
        name: {
            required,
            minLength: minLength(4)
        }
    },
    methods: {
        addRepair(e) {

            e.preventDefault();
            let currentObj = this;
            var self = this;

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('name', this.name);
            formData.append('description', this.description);

            axios.post("/api/serwisant/addRepair/" + this.device, formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                    Fire.$emit("AfterChange");
                    self.hide("modal-step");
                }).catch(error => this.errors.record(error.response.data));

            this.image = "";
            this.name = "";
            this.description = "";
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
        loadRepairs() {
            axios.get("/api/serwisant/showRepairs/" + this.device)
                .then(response => (this.repairs = response.data));
        }
    },
    created() {
        this.loadRepairs();
        Fire.$on("AfterChange", () => {
            this.loadRepairs();
        });
    }
}
</script>

<style>

</style>
