<template>
  <div class="card-body">
    <hr class="bg-info" />
    <div class="row">
      <div class="col-lg-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
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
            <tr v-for="user in users.data" :key="user.id">
              <td>{{user.name}}</td>
              <td>{{user.email}}</td>
              <td v-if="user.banned_until === null">
                <a href="#" @click="addBan(user.id)">
                  <button type="button" class="btn btn-success">Nie</button>
                </a>
              </td>
              <td v-else>
                <a href="#" @click="deleteBan(user.id)">
                  <button type="button" class="btn btn-warning">Tak</button>
                </a>
              </td>
              <td v-if="user.roles[0] && user.roles[0].id === 1">
                <a href="#">
                  <i class="far fa-check-square"></i>
                </a>
              </td>
              <td v-else>
                <a href="#">
                  <i class="far fa-square"></i>
                </a>
              </td>
              <td v-if="user.roles[1] && user.roles[1].id === 2">
                <a href="#" @click="deleteSerwisant(user.id)">
                  <i class="far fa-check-square"></i>
                </a>
              </td>
              <td v-else-if="user.roles[2] && user.roles[2].id === 2">
                <a href="#" @click="deleteSerwisant(user.id)">
                  <i class="far fa-check-square"></i>
                </a>
              </td>
              <td v-else>
                <a href="#" @click="addSerwisant(user.id)">
                  <i class="far fa-square"></i>
                </a>
              </td>
              <td v-if="user.roles[2] && user.roles[2].id === 3">
                <a href="#" @click="deleteAdmin(user.id)">
                  <i class="far fa-check-square"></i>
                </a>
              </td>
              <td v-else-if="user.roles[1] && user.roles[1].id === 3">
                <a href="#" @click="deleteAdmin(user.id)">
                  <i class="far fa-check-square"></i>
                </a>
              </td>
              <td v-else>
                <a href="#" @click="addAdmin(user.id)">
                  <i class="far fa-square"></i>
                </a>
              </td>

              <td>
                <button @click="deleteUser(user.id)" type="button" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer">
          <pagination :data="users" @pagination-change-page="getResults"></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: {},
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/ShowUser?page=" + page).then((response) => {
        this.users = response.data;
      });
    },
    deleteUser(id) {
      Swal.fire({
        title: "Na pewno chcesz usunąć użytkownika ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("api/DeleteUser/" + id)
            .then(() => {
              Swal.fire("Użytkownik został usunięty.");
              Fire.$emit("AfterDelete");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },

    addSerwisant(id) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Rola została dodana",
        showConfirmButton: false,
        timer: 1500,
      }).then((result) => {
        axios
          .delete("api/AddSerwisant/" + id)
          .then(() => {
            Fire.$emit("AfterDelete");
          })
          .catch(() => {
            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
          });
      });
    },

    addAdmin(id) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Rola została dodana",
        showConfirmButton: false,
        timer: 1500,
      }).then((result) => {
        axios
          .delete("api/AddAdmin/" + id)
          .then(() => {
            Fire.$emit("AfterDelete");
          })
          .catch(() => {
            Swal("Failed!", "Coś poszło nie tak.", "Uwaga");
          });
      });
    },

    deleteSerwisant(id) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Rola została usunięta",
        showConfirmButton: false,
        timer: 1500,
      }).then((result) => {
        axios
          .delete("api/DeleteSerwisant/" + id)
          .then(() => {
            Fire.$emit("AfterDelete");
          })
          .catch(() => {
            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
          });
      });
    },

    deleteAdmin(id) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Rola została usunięta",
        showConfirmButton: false,
        timer: 1500,
      }).then((result) => {
        axios
          .delete("api/DeleteAdmin/" + id)
          .then(() => {
            Fire.$emit("AfterDelete");
          })
          .catch(() => {
            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
          });
      });
    },

    addBan(id) {
      Swal.fire({
        title: "Na pewno chcesz zbanować użytkownika ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("api/AddBan/" + id)
            .then(() => {
              Fire.$emit("AfterDelete");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },

    deleteBan(id) {
      Swal.fire({
        title: "Na pewno chcesz odbanować użytkownika ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak!",
      }).then((result) => {
        axios
          .delete("api/DeleteBan/" + id)
          .then(() => {
            Fire.$emit("AfterDelete");
          })
          .catch(() => {
            Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
          });
      });
    },

    loadUsers() {
      axios
        .get("api/ShowUser")
        .then((response) => (this.users = response.data));
    },
  },
  created() {
    this.loadUsers();
    Fire.$on("AfterDelete", () => {
      this.loadUsers();
    });
  },
};
</script>

<style>
.fa-trash {
  color: red;
}
</style>
