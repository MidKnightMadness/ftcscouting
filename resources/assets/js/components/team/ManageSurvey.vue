<style scoped>
    .m-t-10 {
        margin-top: 10px;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .25s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

    .archive {
        font-style: oblique;
        color: #ACACAC;
    }
</style>

<template>
    <div>
        <a href="/survey/create" class="btn btn-default btn-block">Create Survey</a>
        <table class="table table-borderless" v-if="surveys.length > 0">
            <thead>
            <tr>
                <th><b>Name</b></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="survey in surveys">
                <td>{{survey.name}} <span v-if="survey.archived" class="archive">(Archived)</span></td>
                <td>
                    <div class="btn-group">
                        <button @click="deleteSurvey(survey)" class="btn btn-danger">Delete</button>
                        <a :href="'/survey/edit/' + survey.id" class="btn btn-default">Edit</a>
                        <a :href="'/survey/'+survey.id+'/responses'" class="btn btn-default">Responses</a>
                    </div>
                </td>
                <td>
                    <div v-if="survey.archived">
                        <button @click="unarchive(survey.id)" class="btn btn-default">Unarchive</button>
                    </div>
                    <div v-else>
                        <button @click="archive(survey.id)" class="btn btn-default">Archive</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="m-t-10" v-else>
            <p>No surveys currently exist. Why not create one?</p>
        </div>

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Survey</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete this survey?
                            It will delete all responses associated with it and <b>CANNOT</b> be undone
                        </p>
                        <button @click="doDelete(toDelete.id)" class="btn btn-danger btn-block">Delete</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
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
                surveys: [],
                toDelete: null
            }
        },

        mounted(){
            this.fetchSurveys()
        },

        props: {
            number: {
                type: String,
                required: true
            }
        },

        methods: {
            fetchSurveys(){
                this.$http.get('/api/team/' + this.number + '/surveys').then(response => {
                    this.surveys = response.data;
                });
            },
            archive(id){
                this.$http.post('/api/survey/' + id + '/archive', {archived: true}).then(r => this.fetchSurveys())
            },
            unarchive(id){
                this.$http.post('/api/survey/' + id + '/archive', {archived: false}).then(r => this.fetchSurveys())
            },
            deleteSurvey(survey){
                this.toDelete = survey;
                $("#confirm-delete").modal("show");
            },
            doDelete(id){
                $("#confirm-delete").modal("hide");
                this.$http.post('/api/survey/'+id+'/delete').then(r => this.fetchSurveys())
            }
        }
    }
</script>