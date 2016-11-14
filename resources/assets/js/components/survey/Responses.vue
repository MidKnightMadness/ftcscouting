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

    .pin {
        font-size: 5em;
        float: right;
    }

    .bold {
        font-size: 2em;
    }

    .m-top-10 {
        margin-top: 10px;
    }
</style>

<template>
    <div>
        <button class="btn btn-default form-control" @click="rank">Rank Teams by PIN&trade;</button>
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
                                <th><b>PIN</b></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="response in responses" :class="{'initial': response.initial}">
                                <td v-if="response.match_number != -1">{{response.match_number}}</td>
                                <td v-else>N/A</td>
                                <td>{{response.submitted_by}}</td>
                                <td>{{response.pin}}</td>
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
                <div class="pin" v-if="responsePin != -1">PIN {{responsePin}}</div>
                <div class="question" v-for="question in viewingResponse">
                    <h3>{{question.question}}</h3>
                    <p>{{question.response_data}}</p>
                </div>
                <button type="button" @click="viewingResponse = null" class="btn btn-sm btn-default"><i class="fa fa-backward" aria-hidden="true"></i></button>
            </div>
        </transition>
        <div class="modal fade" id="ranked" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ranked PIN</h4>
                    </div>
                    <div class="modal-body">
                       <ol>
                           <li v-for="(team, index) in rankedTeams" :class="{bold: index < 3}">{{team.team}} ({{team.pin}})</li>
                       </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                allResponses: [],
                responses:[],
                viewingResponse:null,
                responsePin: -1,
                rankedTeams:[],
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
                this.getPin(id);
                this.$http.get('/api/response/' + id + '/data').then(resp=> {
                    this.viewingResponse = resp.data;
                });
            },

            viewResponses(team){
                this.responses = [];
                this.allResponses.forEach(r => {
                    if(r.team == team)
                        this.responses.push(r);
                })
            },

            getPin(id){
                this.$http.get('/api/response/'+id+'/pin').then(resp => {
                    this.responsePin = resp.data;
                })
            },

            rank(){
                this.$http.get('/api/survey/'+this.id+'/rank').then(resp => {
                    this.rankedTeams = resp.data;
                    $("#ranked").modal('show');
                })
            }
        }
    }
</script>