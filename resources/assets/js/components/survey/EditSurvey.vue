<style scoped>
    textarea {
        resize: none;
    }

    .edit {
        cursor: pointer;
    }

    .edit label {
        cursor: pointer;
    }

    .edit b {
        cursor: pointer;
    }

    input[disabled] {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div v-for="question in questions" class="edit">
            <div class="form-group" @click="edit(question)">
                <label :for="generateId(question.id)">{{question.question_name}}</label>
                <input type="text" :name="generateId(question.id)" :id="generateId(question.id)" disabled class="form-control" v-if="question.question_type == 'short_text'"/>
                <input type="number" :name="generateId(question.id)" :id="generateId(question.id)" disabled class="form-control" v-if="question.question_type == 'number'"/>
                <textarea class="form-control" :id="generateId(question.id)" disabled v-if="question.question_type == 'long_text'"></textarea>
                <div :id="generateId(question.id)" v-if="checkboxOrRadio(question)">
                    <div v-for="option in parseExtraData(question).options" v-if="question.question_type == 'checkbox'">
                        <input type="checkbox" :name="option.name" :checked="option.checked" :value="option.name" disabled>
                        <b>{{option.name | capitalize}}</b><br/>
                    </div>
                    <div v-for="option in parseExtraData(question).options" v-if="question.question_type == 'radio'">
                        <input type="radio" :name="option.name" :checked="option.checked" :value="option.name" disabled>
                        <b>{{option.name | capitalize}}</b><br/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-default form-control" @click="newQuestion">Add Question</button>
        </div>

        <div class="modal fade" id="edit-question" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="editingQuestion">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Question</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input id="edit-name" type="text" v-model="editingQuestion.question_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">Question Type</label>
                            <select id="type" v-model="editingQuestion.question_type" class="form-control">
                                <option value="short_text">Text</option>
                                <option value="long_text">Long Text</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio</option>
                            </select>
                            <label for="order">Order</label>
                            <input id="order" type="number" v-model="editingQuestion.order" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit-radio" v-if="checkboxOrRadio(editingQuestion)">Options</label>
                            <div id="edit-radio" v-if="checkboxOrRadio(editingQuestion)">
                                <div class="input-group" v-for="(option, index) in editingQuestion.extra_data.options" style="margin-bottom: 10px">
                                    <span class="input-group-addon"><input type="checkbox" v-model="option.checked"/></span>
                                    <input type="text" class="form-control" v-model="option.name">
                                    <span class="input-group-btn"><button class="btn btn-default" type="button" @click="removeOption(index)">Remove</button></span>
                                </div>
                                <button class="btn btn-default form-control" @click="addOption()">Add Option</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" @click="del()">Delete Question</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" @click="cancel()">Cancel</button>
                            <button type="button" class="btn btn-success" @click="save()">Save</button>
                        </div>
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
                questions: [],
                editingQuestion: {
                    question_name: '',
                    question_type: '',
                    order: -1,
                    extra_data: {
                        options: []
                    }
                },
            }
        },

        props: {
            id: {
                type: String,
                required: true
            }
        },

        mounted(){
            this.prepare();
        },

        methods: {

            prepare(){
                this.retrieveSurveyQuestions();
            },

            retrieveSurveyQuestions(){
                this.$http.get('/api/survey/' + this.id + '/questions').then(resp => {
                    this.questions = resp.data;
                });
            },

            generateId(id){
                return 'question-' + id;
            },

            parseExtraData(question){
                return JSON.parse(question.extra_data);
            },

            checkboxOrRadio(question){
                return question.question_type == 'checkbox' || question.question_type == 'radio';
            },

            edit(question){
                this.editingQuestion = jQuery.extend({}, question);
                if (question.extra_data != '')
                    this.editingQuestion.extra_data = this.parseExtraData(this.editingQuestion);
                $('#edit-question').modal('show');
            },

            addOption(){
                this.editingQuestion.extra_data.options.push({
                    checked: false,
                    name: ''
                })
            },

            removeOption(option){
                this.editingQuestion.extra_data.options.splice(option, 1);
            },

            cancel(){
                $('#edit-question').modal('hide');
            },

            del(){
                this.$http.post('/api/question/' + this.editingQuestion.id + '/delete', {id: this.editingQuestion.id}).then(e => {
                    $('#edit-question').modal('hide');
                    this.retrieveSurveyQuestions();
                });
            },

            save(){
                this.$http.post('/api/question/' + this.editingQuestion.id + '/update', {data: this.editingQuestion}).then(e=> {
                    $('#edit-question').modal('hide');
                    this.retrieveSurveyQuestions();
                })
            },

            newQuestion(){
                this.$http.get('/api/survey/' + this.id + '/new-question', {id: this.id}).then(e=> {
                    this.questions.push(e.data);
                })
            }
        },

        filters: {
            capitalize: function (value) {
                if (!value) return '';
                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        }
    }
</script>