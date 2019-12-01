<template>
    <div class="input-dynamic_text">
        <label :for="attrs.id" :style="label_style">{{ input_label }}</label>
        <input v-bind="attrs" type="text" :style="input_style" placeholder="" @focus="placeholderAdd" @blur="placeholderRemove">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                attrs: {
                    name: this.input_name,
                    id: this.input_id,
                    class: this.input_custom_class,
                    maxlength: this.input_max_length,
                    required: this.input_required
                }
            }
        },
        props: [
            'input_label', 
            'input_name', 
            'input_id', 
            'input_border_color', 
            'input_label_color', 
            'input_placeholder', 
            'input_custom_class', 
            'input_max_length', 
            'input_required'
        ],
        computed: {
            input_style() {
                return (`border-bottom-color: ${this.input_border_color};`);
            },
            label_style() {
                return (`color: ${this.input_label_color};`);
            }
        },
        methods: {
            placeholderAdd: function(e) {
                const placeholder = this.input_placeholder;
                if (placeholder) e.target.placeholder = placeholder;
            },
            placeholderRemove: function(e) {
                e.target.placeholder = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .input-dynamic_text {
        position: relative;
        width: 100%;
        margin-bottom: 25px;
        display: inline-block;
        label {
            position: absolute;
            transition: 130ms cubic-bezier(0.65, 0.26, 0.52, 0.96);
            pointer-events: none;
        }
        input {
            width: inherit;
            padding: 5px;
            border-bottom-width: 2px;
            border-bottom-style: solid;
        }
        .focused {
            transform: translate(-15%, -60%) scale(.7);
        }
    }
</style>