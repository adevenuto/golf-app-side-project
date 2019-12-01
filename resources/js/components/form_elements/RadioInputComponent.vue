<template>
    <div class="input-dynamic_radio">
        <div :style="label_style" :class="[{'focused': selected}, 'radio-for']">{{input_label}}</div>
        <div class="d-flex flex-wrap">
            <label v-for="option in options" :key="option.display_name">
                <input type="radio" :name="name" :value="option.value" :required="option.required" @click="animateLabel"> 
                <div class="radio_indicator">
                    <div class="wave" :style="wave_style"></div>
                </div>
                <span>{{option.display_name}}</span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: this.input_name,
                options: this.input_radio_options,
                selected: false
            }
        },
        props: [
             'input_label', 
             'input_label_color', 
             'input_name',  
             'input_radio_options', 
             'bg_color_wave'
        ],
        computed: {
            wave_style() {
                return (`background: ${this.bg_color_wave};`);
            },
            label_style() {
                return (`color: ${this.input_label_color};`);
            }
        },
        methods: {
            animateLabel: function() {
                this.selected = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .input-dynamic_radio {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
        display: inline-block;
        .radio-for {
            margin-bottom: 4px;
        }
        input[type=radio] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        input[type=radio]:checked + .radio_indicator
        {
            transform: scale(1.15);
        }
        input[type=radio] + .radio_indicator .wave {
            display: none;
        }
        input[type=radio]:checked + .radio_indicator .wave {
            display: block;
            position: absolute;
            content: '';
            height: inherit;
            width: inherit;
            border-radius: inherit;
            -webkit-animation: radioWave 200ms;
            -moz-animation: radioWave 200ms;
            animation: radioWave 200ms;
            z-index: -1;
        }
        label {
            display: flex;
            align-items: center;
            cursor: pointer;
            span {
                margin: 0 15px 0 5px;
            }
            .radio_indicator {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 13px;
                width: 13px;
                border: 1px solid #6f6f6f;
                border-radius: 50%;
                transform: scale(1);
                transition: all 100ms cubic-bezier(0, 1.06, 0, 1.06);
                box-sizing: content-box;
            }
        }
        .focused {
            transform: translate(-15%, -20%) scale(.7);
            transition: 130ms cubic-bezier(0.65, 0.26, 0.52, 0.96);
        }
    }
    @keyframes radioWave {
        0% {
            height: 13px;
            width: 13px;
            opacity: 0.45;
        }
        100% {
            height: 28px;
            width: 28px;
            opacity: 0;
        }
    }
</style>