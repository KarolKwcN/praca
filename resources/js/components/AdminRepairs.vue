<template>
  <div class="card-body">
    <div class="float-left">
      <a class="text-reset" href>Kategorie</a>
    </div>
    <br />
    <hr class="bg-info" />
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" @click.prevent="show" class="btn btn-success">Modal</button>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center bg-info text-light">
              <th>Lp.</th>
              <th>Nazwa kategorii</th>
              <th>Edytuj</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(category, index) in categories.data" :key="category.id" class="text-center">
              <td>{{index +1}}</td>
              <td>
                <a href>{{category.name}}</a>
              </td>
              <td>
                <button type="button" class="btn btn-info">
                  <i class="fas fa-edit"></i>
                </button>
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
          <pagination :data="categories" @pagination-change-page="getResults"></pagination>
        </div>
        <div class="col-12 d-flex justify-content-center"></div>
      </div>
    </div>
    <div>
      <modal name="modal-step" height="auto" classes="demo-modal-class">
        <div
          id="exampleModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nowa kategoria</h5>
                <button
                  @click.prevent="hide"
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="/api/admin/addCategory" method="POST" @submit.prevent="addCategory()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nazwa kategorii:</label>
                    <input
                      type="text"
                      v-model="name"
                      name="name"
                      class="form-control"
                      id="recipient-name"
                    />
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    @click.prevent="hide"
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >Zamknij</button>
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
export default {
  data() {
    return {
      name: "",
      categories: {}
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("/api/admin/showCategory?page=" + page).then(response => {
        this.categories = response.data;
      });
    },
    addCategory() {
      axios.post("/api/admin/addCategory", {
        name: this.name
      });
      Event.$emit("categoryCreated", {
        name: this.name
      });

      this.name = "";
    },
    show() {
      this.$modal.show("modal-step");
    },
    hide() {
      this.$modal.hide("modal-step");
    }
  },
  created() {
    axios
      .get("/api/admin/showCategory")
      .then(response => (this.categories = response.data));

    Event.$on("categoryCreated", name => {
      this.categories.push(name);
    });
  }
};
</script>

<style>
</style>
