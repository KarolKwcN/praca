<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>Nazwa</th>
                        <th>Serwisant</th>
                        <th>Status</th>
                        <th>Zaakceptowane</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="rep in repairs" :key="rep.id" class="text-center">
                        <td>

                             <a :href="`/naprawa/`+rep.devices.brand.category.slug+`/`+rep.devices.brand.slugi+`/`+rep.devices.slugii+'/'+rep.id+'/'+rep.slugi_repair">
                                {{rep.name}}
                            </a>
                      

                        </td>
                        <td>
                            {{rep.users.email}}
                        </td>
                        <td>
                            <span v-if="rep.status === 0">

                                <button type="button" class="btn btn-info">W realizacji</button>

                            </span>
                            <span v-else>
                                <span v-if="rep.accept === 0">
                                    <a href="#" @click="przekazdorealziacji(rep.id)">
                                        <button type="button" class="btn btn-success">Zakończone</button>
                                    </a>
                                </span>
                                <span v-else>
                                    <a href="#" @click="przekazdorealziacjii(rep.id)">
                                        <button type="button" class="btn btn-success">Zakończone</button>
                                    </a>
                                </span>
                            </span>
                        </td>
                        <td>
                            <span v-if="rep.accept === 0">
                                <span v-if="rep.status === 0">
                                    <a href="#" @click="akceptujj(rep.id)">
                                        <button type="button" class="btn btn-info">Nie</button>
                                    </a>
                                </span>
                                <span v-else>
                                    <a href="#" @click="akceptuj(rep.id)">
                                        <button type="button" class="btn btn-info">Nie</button>
                                    </a>
                                </span>
                            </span>
                            <span v-else>
                                <a href="#" @click="odrzuc(rep.id)">
                                    <button type="button" class="btn btn-success">Tak</button>
                                </a>
                            </span>
                        </td>
                        <td>
                            <a href="#" @click="deleterepair(rep.id)">
                            <button type="button" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="card-footer">

            </div>
            <div class="col-12 d-flex justify-content-center"></div>
        </div>
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
            repairs: {},
        };

    },
    methods: {
        loadRepairs() {
            axios
                .get("/api/admin/showDeviceRepairs/" + this.device)
                .then(response => (this.repairs = response.data));
        },
        akceptuj(id) {
            Swal.fire({
                title: "Napewno chcesz zaakceptować naprawę?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak!"
            }).then(result => {
                if (result.value) {
                    axios
                        .put("/api/admin/akceptujnaprawe/" + id)
                        .then(() => {
                            Fire.$emit("AfterChange");
                        })
                        .catch(() => {
                            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
                        });
                }
            });
        },
        odrzuc(id) {
            Swal.fire({
                title: "Napewno chcesz odrzucić naprawę?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak!"
            }).then(result => {
                if (result.value) {
                    axios
                        .put("/api/admin/odrzucnaprawe/" + id)
                        .then(() => {
                            Fire.$emit("AfterChange");
                        })
                        .catch(() => {
                            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
                        });
                }
            });
        },
        przekazdorealziacji(id) {
            Swal.fire({
                title: "Napewno chcesz przekazać naprawę do realziacji ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak!"
            }).then(result => {
                if (result.value) {
                    axios
                        .put("/api/admin/przekazdorealziacji/" + id)
                        .then(() => {
                            Fire.$emit("AfterChange");
                        })
                        .catch(() => {
                            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
                        });
                }
            });
        },
        przekazdorealziacjii(id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nie można zmienić statusu na "W realizacji", kiedy naprawa jest zaakceptowana.',
            })
        },
        akceptujj(id) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nie można zaakceptować naprawy , kiedy naprawa jest w realizacji.',
            })
        },
        deleterepair(id){
            Swal.fire({
                title: "Napewno chcesz usunąc naprawę ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Tak!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/api/deleteRepair/" + id)
                        .then(() => {
                            Fire.$emit("AfterChange");
                        })
                        .catch(() => {
                            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
                        });
                }
            });
        }
    },
    created() {
        this.loadRepairs();
        Fire.$on("AfterChange", () => {
            this.loadRepairs();
        });

    }
};
</script>

<style>

</style>
