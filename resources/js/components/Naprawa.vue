<template>
<div class="container">

    <div class="py-5">
        <div class="container">
            <div class="row" v-for="(step, indx ) in steps" :key="indx" :index="indx">

                <div class=" pl-md-4 col-lg-6 col-8 order-2 order-lg-1">
                    <h2>Krok {{indx+1}}</h2>
                    <hooper style="height: 400px" :centerMode="true">
                        <slide v-for="(stepimage, indx) in step.imagesteps" :key="indx" :index="indx">
                            <div class="images">
                                <a :href='stepimage.image'> <img class="img-fluid d-block new2" :src='stepimage.image'></a>
                            </div>

                        </slide>
                        <hooper-navigation slot="hooper-addons"></hooper-navigation>
                    </hooper>

                </div>
                <div class="pr-md-5 p-3  flex-column justify-content-center col-lg-6 order-1 order-lg-3">
                    <div class="text-center">
                        <h3>{{step.name}}</h3>
                    </div>
                    <span v-html="step.description"></span>
                </div>

                <div class="form-group col-12">
                    <hr>
                </div>
            </div>
            <div class="form-group col-14">
                <hr>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    Hooper,
    Slide,
    Navigation as HooperNavigation
} from 'hooper';
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
            steps: [],
        }
    },

    methods: {

        loadSteps() {
            this.steps = [];
            axios.get("/api/serwisant/showSteps/" + this.repair)
                .then(response => (this.steps = response.data));

        },
    },
    created() {

        this.loadSteps();

    }

}
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
