<template>
<div class="card-body">
    <hr class="bg-info">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>ID</th>
                        <th>Imię</th>
                        <th>E-Mail</th>
                        <th>Ban</th>
                        <th>User</th>
                        <th>Serwisant</th>
                        <th>Admin</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="user in users" :key="user.id">

                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}} </td>
                        <td>tak/nie</td>
                        <td v-if="user.roles[0] && user.roles[0].id === 1"><a href="#"><i class="far fa-check-square"></i></a></td>
                        <td v-else><a href="#"><i class="far fa-square"></i></a></td>
                        <td v-if="user.roles[1] && user.roles[1].id === 2"><a href="#" @click="deleteSerwisant(user.id)"><i class="far fa-check-square"></i></a></td>
                        <td v-else-if="user.roles[2] && user.roles[2].id === 2"><a href="#" @click="deleteSerwisant(user.id)"><i class="far fa-check-square"></i></a></td>
                        <td v-else><a href="#" @click="addSerwisant(user.id)"><i class="far fa-square"></i></a></td>
                        <td v-if="user.roles[2] && user.roles[2].id === 3"><a href="#" @click="deleteAdmin(user.id)"><i class="far fa-check-square"></i></a></td>
                        <td v-else-if="user.roles[1] && user.roles[1].id === 3"><a href="#" @click="deleteAdmin(user.id)"><i class="far fa-check-square"></i></a></td>
                        <td v-else><a href="#" @click="addAdmin(user.id)"><i class="far fa-square"></i></a></td>

                        <td><a href="#" @click="deleteUser(user.id)">
                                <i class="fa fa-trash red"></i>
                            </a></td>

                    </tr>
                </tbody>

            </table>

        </div>

    </div>
</div>
</template>

<script>
export default {

    data() {

        return {
            users: [],

        }
    },
    methods: {
        deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.delete('api/DeleteUser/' + id).then(() => {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterDelete');
                    }).catch(() => {
                        Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
                    });
                }
            })
        },

        addSerwisant(id) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {

                axios.delete('api/AddSerwisant/' + id).then(() => {

                    Fire.$emit('AfterDelete');
                }).catch(() => {
                    Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
                });

            })
        },

        addAdmin(id) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {

                axios.delete('api/AddAdmin/' + id).then(() => {

                    Fire.$emit('AfterDelete');
                }).catch(() => {
                    Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
                });

            })
        },

        deleteSerwisant(id) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {

                axios.delete('api/DeleteSerwisant/' + id).then(() => {

                    Fire.$emit('AfterDelete');
                }).catch(() => {
                    Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
                });

            })
        },

        deleteAdmin(id) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {

                axios.delete('api/DeleteAdmin/' + id).then(() => {

                    Fire.$emit('AfterDelete');
                }).catch(() => {
                    Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
                });

            })
        },

        loadUsers() {
            axios.get("api/ShowUser").then(response => this.users = response.data);

        },
    },
    created() {
        this.loadUsers();
        Fire.$on('AfterDelete', () => {
            this.loadUsers();
        });
    }

}
</script>

<style>
.fa-trash {
    color: red
}
</style>
