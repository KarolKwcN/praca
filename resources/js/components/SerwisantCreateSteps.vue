<template>
  <div class="container">
    <div v-if="!steps.length || steps[0].repairs.status === 0" class="new1">
      <button type="button" @click.prevent="show" class="btn btn-primary">Dodaj krok</button>
    </div>

    <div class="py-5">
      <div class="container">
        <div class="row" v-for="(step, indx ) in steps" :key="indx" :index="indx">
          <div class="pl-md-4 col-lg-6 col-8 order-2 order-lg-1">
            <h2>Krok {{indx+1}}</h2>
            <hooper style="height: 400px" :centerMode="true">
              <slide v-for="(stepimage, indx) in step.imagesteps" :key="indx" :index="indx">
                <div class="images">
                  <a :href="stepimage.image">
                    <img class="img-fluid d-block new2" :src="stepimage.image" />
                  </a>
                </div>
              </slide>
              <hooper-navigation slot="hooper-addons"></hooper-navigation>
            </hooper>
          </div>
          <div class="pr-md-5 p-3 flex-column justify-content-center col-lg-6 order-1 order-lg-3">
            <div class="text-center">
              <h3>{{step.name}}</h3>
            </div>
            <span v-html="step.description"></span>

            <button
              v-if="steps[0].repairs.status === 0"
              @click="editModal(indx)"
              type="button"
              class="btn btn-info"
            >Edytuj</button>
            <button
              v-if="steps[0].repairs.status === 0"
              @click="deleteModal(step.id)"
              type="button"
              class="btn btn-danger"
            >Usuń</button>
          </div>

          <div class="form-group col-12">
            <hr />
          </div>
        </div>
        <div class="form-group col-14">
          <hr />
        </div>
      </div>
    </div>

    <modal style="overflow-y: auto;" name="modal-step" height="auto" classes="demo-modal-class">
      <div
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" v-model="name" name="name" id="name" placeholder="Nazwa kroku" />
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label>Upload Files</label>
                  <input
                    id="upload-file"
                    type="file"
                    accept="image/*"
                    multiple
                    class="form-control"
                    style="display: none;"
                    @change="fieldChange"
                  />
                  <input
                    type="button"
                    value="Browse..."
                    onclick="document.getElementById('upload-file').click();"
                  />
                </div>
                <div class="field">
                  <div
                    v-for="(file, indx) in attachments"
                    :key="indx"
                    :class="`level ${file.invalidMessage && 'text-danger'}`"
                  >
                    <div class="input-group pb-2">
                      {{file.name}}
                      <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>

                      <div class="form-group-append">
                        <button
                          @click.prevent="attachments.splice(indx, 1);uploadFiles.splice(indx, 1)"
                          class="btn btn-danger mx-2"
                          type="button"
                        >Usuń</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <vue-editor v-model="description" :editorToolbar="customToolbar"></vue-editor>
            </div>
            <button class="btn btn-primary" @click="uploadFile">Submit</button>
          </div>
        </div>
      </div>
    </modal>

    <modal style="overflow-y: auto;" name="modal-update" height="auto" classes="demo-modal-class">
      <div
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" v-model="update_step.name" name="name" id="name" />
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label>Upload Files</label>
                  <input
                    id="upload-file"
                    type="file"
                    accept="image/*"
                    multiple
                    class="form-control"
                    style="display: none;"
                    @change="fieldChange"
                  />
                  <input
                    type="button"
                    value="Browse..."
                    onclick="document.getElementById('upload-file').click();"
                  />
                </div>
                <div class="field">
                  <div
                    v-for="(file, index) in update_step.imagesteps"
                    :key="index"
                    :class="`level ${file.invalidMessage && 'text-danger'}`"
                  >
                    <div class="input-group pb-3">
                      <img width="150px" class="img-fluid d-block new2 mx-2" :src="file.image" />
                      <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>

                      <div class="form-group-append">
                        <button
                          @click.prevent="update_step.imagesteps.splice(index, 1);uploadFiles.splice(index, 1)"
                          class="btn btn-danger mx-2"
                          type="button"
                        >Usuń</button>
                      </div>
                    </div>
                  </div>
                  <div
                    v-for="(file, indx) in attachments"
                    :key="indx"
                    :class="`level ${file.invalidMessage && 'text-danger'}`"
                  >
                    <div class="input-group pb-2">
                      {{file.name}}
                      <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>

                      <div class="form-group-append">
                        <button
                          @click.prevent="attachments.splice(indx, 1);uploadFiles.splice(indx, 1)"
                          class="btn btn-danger mx-2"
                          type="button"
                        >Usuń</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <vue-editor v-model="update_step.description" :editorToolbar="customToolbar"></vue-editor>
            </div>
            <button class="btn btn-primary" @click="editStep">Submit</button>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import { Hooper, Slide, Navigation as HooperNavigation } from "hooper";
import "hooper/dist/hooper.css";
import axios from "axios";
import { VueEditor } from "vue2-editor";
export default {
  props: ["repair"],
  name: "MultipleUpload",

  components: {
    VueEditor,
    Hooper,
    Slide,
    HooperNavigation
  },

  data() {
    return {
      update_step: [],
      name: "",
      description: "",
      uploadFiles: [],
      attachments: [],
      steps: [{ repairs: [] }],
      customToolbar: [
        ["bold", "italic", "underline"],
        [
          {
            list: "ordered"
          },
          {
            list: "bullet"
          }
        ],
        [
          {
            align: ""
          },
          {
            align: "center"
          },
          {
            align: "right"
          },
          {
            align: "justify"
          }
        ],
        [
          {
            color: []
          }
        ]
      ],
      form: new FormData()
    };
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
        this.form.append("pics[]", this.attachments[i]);
      }
      this.form.append("name", this.name);
      this.form.append("description", this.description);
      const config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      document.getElementById("upload-file").value = [];
      axios
        .post("/api/serwisant/naprawa/step/" + this.repair, this.form, config)
        .then(response => {
          //success
          console.log(response);
          Fire.$emit("AfterChange");
          this.$modal.hide("modal-step");
        })
        .catch(response => {
          //error
        });

      this.name = "";
      this.description = "";
      this.attachments = [];
    },
    editStep() {
      for (let i = 0; i < this.attachments.length; i++) {
        this.form.append("pics[]", this.attachments[i]);
      }

      for (let i = 0; i < this.update_step.imagesteps.length; i++) {
        this.form.append("picss[]", this.update_step.imagesteps[i].image);
      }

      this.form.append("id", this.update_step.id);
      this.form.append("name", this.update_step.name);
      this.form.append("description", this.update_step.description);
      const config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };

      document.getElementById("upload-file").value = [];
      axios
        .post(
          "/api/serwisant/updatestep/" + this.update_step.id,
          this.form,
          config
        )
        .then(response => {
          //success
          console.log(response);
          Fire.$emit("AfterChange");
          this.$modal.hide("modal-update");
        })
        .catch(response => {
          //error
        });

      this.name = "";
      this.description = "";
      this.attachments = [];
      this.update_step.imagesteps = [];
      this.update_step = [];
    },
    deleteModal(id) {
      Swal.fire({
        title: "Napewno chcesz usunąć krok ?",
        text: "Nie będzie można tego cofnąć.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!"
      }).then(result => {
        if (result.value) {
          axios
            .delete("/api/serwisant/deleteStep/" + id)
            .then(() => {
              Swal.fire("Krok został usunięty");
              Fire.$emit("AfterChange");
            })
            .catch(() => {
              Swal("Błąd!", "Coś poszło nie tak.", "Uwaga");
            });
        }
      });
    },
    editModal(indx) {
      this.$modal.show("modal-update");
      this.update_step = this.steps[indx];
    },
    show() {
      this.$modal.show("modal-step");
    },
    hide() {
      this.$modal.hide("modal-step");
    },
    loadSteps() {
      this.steps = [];
      axios
        .get("/api/serwisant/showSteps/" + this.repair)
        .then(response => (this.steps = response.data));
    }
  },
  created() {
    this.loadSteps();
    Fire.$on("AfterChange", () => {
      this.loadSteps();
      this.form.delete("picss[]");
      this.form.delete("pics[]");
    });
  }
};
</script>

<style>
.images {
  max-width: 100%;
  height: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
}

.new1 {
  padding-left: 30px;
}

.new2 {
  border-radius: 1%;
}
</style>
