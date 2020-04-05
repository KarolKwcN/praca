<template>
<div class="card-body">
    <hr class="bg-info">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info text-light">
                        <th>Lp.</th>
                        <th>Imię</th>
                        <th>E-Mail</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="user in users" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}} </td>
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
            users: {},

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
