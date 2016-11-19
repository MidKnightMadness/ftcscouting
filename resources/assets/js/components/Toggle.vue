<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .25s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<template>
    <div>
        <div v-if="!bottom">
            <label :for="name">{{display}}</label>
            <input type="checkbox" :id="name" v-model="checked"/>
        </div>
        <transition name="fade">
            <div>
                <slot v-if="shouldShow"></slot>
            </div>
        </transition>
        <div v-if="bottom">
            <label :for="name">{{display}}</label>
            <input type="checkbox" :id="name" v-model="checked"/>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            visible: {
                type: String,
                default: "true",
            },
            name: {
                type: String,
                required: true
            },
            display: {
                type: String,
                required: true
            },
            checkboxOnBottom: {
                type: String,
                default: "false"
            },
            invert: {
                type: String,
                default: "false",
            }
        },

        computed: {
            shouldShow(){
                if (this.inverted)
                    return !this.checked;
                else
                    return this.checked;
            }
        },

        data(){
            return {
                inverted: this.invert == "true",
                checked: this.visible == "true",
                bottom: this.checkboxOnBottom == "true",
            }
        },

        mounted(){
            if (this.inverted)
                this.checked = !this.checked;
        }
    }
</script>