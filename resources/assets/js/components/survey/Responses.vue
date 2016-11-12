<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .25s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

    .initial {
        background: #1bb200;
    }
</style>

<template>
    <div>
        <transition name="fade">
            <div v-if="!viewingResponse">
                <transition name="fade">
                    <div v-if="allResponses" data-id="allresults">
                        <table v-if="responses.length == 0" class="table table-borderless">
                            <thead>
                            <tr>
                                <th><b>Team</b></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="team in teams">
                                <td>{{team}}</td>
                                <td><button @click="viewResponses(team)" class="btn btn-default">View</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </transition>
                <transition name="fade">
                    <div v-if="responses.length > 0" data-id="results">
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th><b>Match #</b></th>
                                <th><b>Submitted By</b></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="response in responses" :class="{'initial': response.initial}">
                                <td v-if="response.match_number != -1">{{response.match_number}}</td>
                                <td v-else>N/A</td>
                                <td>{{response.submitted_by}}</td>
                                <td>
                                    <button type="button" @click="viewResponse(response.id, response.initial)" class="btn btn-default">View</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button @click="responses = []" class="btn btn-default"><i class="fa fa-backward" aria-hidden="true"></i></button>
                    </div>
                </transition>
            </div>
        </transition>
        <transition name="fade">
            <div v-if="viewingResponse" data-id="response">
                <div class="question" v-for="question in viewingResponse">
                    <h3>{{question.question}}</h3>
                    <p>{{question.response_data}}</p>
                </div>
                <button type="button" @click="viewingResponse = null" class="btn btn-sm btn-default"><i class="fa fa-backward" aria-hidden="true"></i></button>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                allResponses: [],
                responses:[],
                viewingResponse:null,
            }
        },

        props: {
            id: {
                type: String,
                required: true
            }
        },

        computed: {
            teams(){
                var teams = [];
                this.allResponses.forEach(e=>{
                    if($.inArray(e.team, teams) == -1){
                        teams.push(e.team);
                    }
                });
                return teams;
            }
        },

        mounted(){
            this.getSurveyData();
            setInterval(function(){
                this.getSurveyData();
            }.bind(this), 30000);
        },

        methods: {
            getSurveyData(){
                this.$http.get('/api/survey/' + this.id + '/allResponses').then(resp => {
                    this.allResponses = resp.data;
                })
            },

            viewResponse(id, initial){
                this.$http.get('/api/response/' + id + '/data').then(resp=> {
                    this.viewingResponse = resp.data;
                })
            },

            viewResponses(team){
                this.responses = [];
                this.allResponses.forEach(r => {
                    if(r.team == team)
                        this.responses.push(r);
                })
            },
        }
    }
</script>