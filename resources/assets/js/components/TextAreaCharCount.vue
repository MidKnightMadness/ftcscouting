<style scoped>
    .feedback {
        float: right;
    }
</style>

<template>
    <div class="form-group" :class="{'has-error': error}">

        <label :for="name">{{prettyName}}</label>
        <span class="help-block" v-if="error">
            <strong>You must enter less than {{maxchars}} characters!</strong>
        </span>
        <textarea :name="name" :rows="rows" :cols="columns" class="form-control" v-model="text"></textarea>
        <div class="feedback">{{charcount}}/{{maxchars}}</div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                text: ''
            }
        },
        props: ['maxchars', 'rows', 'columns', 'name', 'content'],

        computed: {
            prettyName: function(){
                return this.name.replace(/\b\w/g, function(l){ return l.toUpperCase() })
            },
            error: function(){
                return this.charcount > this.maxchars;
            },
            charcount: function () {
                return this.text.length;
            },
        },

        mounted() {
            this.text = this.content;
        }
    }
</script>