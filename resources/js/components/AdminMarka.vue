<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="float-right">
                <button type="button" @click.prevent="show" class="btn btn-success">Dodaj markę</button>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>Id.</th>
                        <th>Nazwa marki</th>
                        <th>Opis</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in brands" :key="brand.id" class="text-center">
                        <td>{{brand.id}}</td>
                        <td>
                            {{brand.name}}
                        </td>
                        <td>{{brand.description}}</td>
                        <td>
                            <button @click="editModal(brand)" type="button" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td>
                            <button @click="deleteBrand(brand.id)" type="button" class="btn btn-danger">
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
                            <h5 class="modal-title" v-show="!editmode" id="exampleModalLabel">Nowa marka</h5>
                            <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Edytuj markę</h5>
                            <button @click.prevent="hide" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/api/admin/addBrand" method="POST" @submit.prevent="editmode ? updateBrand() : addBrand()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nazwa marki:</label>
                                    <input type="text" v-model="form.name" name="name" class="form-control" id="recipient-name" />
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Opis marki:</label>
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
    props: ['category'],
    data() {
        return {
            editmode: false,
            brands: {},
            form: new Form({
                id: "",
                name: "",
                description: ""
            })
        }

    },
    methods: {
        updateBrand() {
            this.form.put("/api/admin/updateBrand/" + this.form.id).then(() => {
                Fire.$emit("AfterDelete");
                this.$modal.hide("modal-step");
            });
        },
        editModal(brand) {
            this.editmode = true;
            this.$modal.show("modal-step");
            this.form.fill(brand);
        },
        addBrand() {
            this.form.post("/api/admin/addBrand/"+this.category).then(() => {
                Fire.$emit("AfterDelete");
                this.$modal.hide("modal-step");
            });
        },
        deleteBrand(id) {
            Swal.fire({
                title: "Napewno chcesz usunąć markę ?",
                text: "Nie będzie można tego cofnąć.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak, usuń!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/api/admin/deleteBrand/" + id)
                        .then(() => {
                            Swal.fire("Marka została usunięta");
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
        loadBrands() {
            axios
                .get("/api/admin/showBrands/" + this.category)
                .then(response => (this.brands = response.data));
        }
    },
    created() {
        this.loadBrands();
        Fire.$on("AfterDelete", () => {
            this.loadBrands();
        });
    }
}
</script>

<style>

</style>
