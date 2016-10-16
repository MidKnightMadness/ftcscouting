<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<template>
    <transition name="fade">
        <div class="container" v-if="show">
            <div :class="className">
                <button type="button" class="close" @click="show = false">&times;</button>
                <p v-if="title">
                    <strong>{{title}}: </strong><slot></slot>
                </p>
                <p v-else>
                    <slot></slot>
                </p>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            type: {
                default: 'info'
            },
            title: {
                type: String
            },
            dismissAfter: {
                type: Number,
                default: 3000,
            },
            autoDismiss: {
                type: Boolean,
                default: true
            }
        },

        data() {
            return {
                show: true
            }
        },

        computed: {
            className: function () {
                return 'alert alert-' + this.type;
            }
        },

        mounted() {
            if(this.autoDismiss)
                setTimeout(()=>this.show = false, this.dismissAfter);
        }
    }
</script>