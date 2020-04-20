<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right">
                <button type="button" @click.prevent="show" class="btn btn-success">Dodaj model</button>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>Id.</th>
                        <th>Model</th>
                        <th>Opis</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="device in devices" :key="device.id" class="text-center">
                        <td>{{device.id}}</td>
                        <td>
                            {{device.name}}
                        </td>
                        <td>{{device.description}}</td>
                        <td>
                            <button @click="editModal(device)" type="button" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td>
                            <button @click="deleteDevice(device.id)" type="button" class="btn btn-danger">
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
                            <h5 class="modal-title" v-show="!editmode" id="exampleModalLabel">Nowy model</h5>
                            <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Edytuj model</h5>
                            <button @click.prevent="hide" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/api/admin/addDevice" method="POST" @submit.prevent="editmode ? updateDevice() : addDevice()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Model:</label>
                                    <input type="text" v-model="form.name" name="name" class="form-control" id="recipient-name" />
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Opis:</label>
                                    <textarea v-model="form.description" class="form-control" id="recipient-description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click.prevent="hide" type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                <input v-show="editmode" type="submit" value="Zmień" class="btn btn-primary" />
                                <input v-show="!editmode" type="submit" value="Dodaj" class="btn btn-primary" />
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
    props: ['brand'],
    data() {
        return {
            editmode: false,
            devices: {},
            form: new Form({
                id: "",
                name: "",
                description: ""
            })
        }

    },
    methods: {
        updateDevice() {
            this.form.put("/api/admin/updateDevice/" + this.form.id).then(() => {
                Fire.$emit("AfterDelete");
                this.$modal.hide("modal-step");
            });
        },
        editModal(device) {
            this.editmode = true;
            this.$modal.show("modal-step");
            this.form.fill(device);
        },
        addDevice() {
            this.form.post("/api/admin/addDevice/" + this.brand).then(() => {
                Fire.$emit("AfterDelete");
                this.$modal.hide("modal-step");
            });
        },
        deleteDevice(id) {
            Swal.fire({
                title: "Napewno chcesz usunąć model ?",
                text: "Nie będzie można tego cofnąć.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak, usuń!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/api/admin/deleteDevice/" + id)
                        .then(() => {
                            Swal.fire("Model został usunięty");
                            Fire.$emit("AfterDelete");
                        })
                        .catch(() => {
                            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
                        });
                }
            });
        },
        show() {
            this.editmode = false;
            this.form.reset();
            this.$modal.show("modal-step");
        },
        hide() {
            this.$modal.hide("modal-step");
        },
        loadDevices() {
            axios
                .get("/api/admin/showDevices/" + this.brand)
                .then(response => (this.devices = response.data));
        },
    },
    created() {

        this.loadDevices();
        Fire.$on("AfterDelete", () => {
            this.loadDevices();
        });
    }
}
</script>

<style>

</style>
