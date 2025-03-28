@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
<style type="text/css">
    :host,
    :root {
        --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Solid";
        --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Regular";
        --fa-font-light: normal 300 1em/1 "Font Awesome 6 Light";
        --fa-font-thin: normal 100 1em/1 "Font Awesome 6 Thin";
        --fa-font-duotone: normal 900 1em/1 "Font Awesome 6 Duotone";
        --fa-font-sharp-solid: normal 900 1em/1 "Font Awesome 6 Sharp";
        --fa-font-sharp-regular: normal 400 1em/1 "Font Awesome 6 Sharp";
        --fa-font-sharp-light: normal 300 1em/1 "Font Awesome 6 Sharp";
        --fa-font-sharp-thin: normal 100 1em/1 "Font Awesome 6 Sharp";
        --fa-font-brands: normal 400 1em/1 "Font Awesome 6 Brands"
    }

    svg:not(:host).svg-inline--fa,
    svg:not(:root).svg-inline--fa {
        overflow: visible;
        box-sizing: content-box
    }

    .svg-inline--fa {
        display: var(--fa-display, inline-block);
        height: 1em;
        overflow: visible;
        vertical-align: -.125em
    }

    .svg-inline--fa.fa-2xs {
        vertical-align: .1em
    }

    .svg-inline--fa.fa-xs {
        vertical-align: 0
    }

    .svg-inline--fa.fa-sm {
        vertical-align: -.0714285705em
    }

    .svg-inline--fa.fa-lg {
        vertical-align: -.2em
    }

    .svg-inline--fa.fa-xl {
        vertical-align: -.25em
    }

    .svg-inline--fa.fa-2xl {
        vertical-align: -.3125em
    }

    .svg-inline--fa.fa-pull-left {
        margin-right: var(--fa-pull-margin, .3em);
        width: auto
    }

    .svg-inline--fa.fa-pull-right {
        margin-left: var(--fa-pull-margin, .3em);
        width: auto
    }

    .svg-inline--fa.fa-li {
        width: var(--fa-li-width, 2em);
        top: .25em
    }

    .svg-inline--fa.fa-fw {
        width: var(--fa-fw-width, 1.25em)
    }

    .fa-layers svg.svg-inline--fa {
        bottom: 0;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0
    }

    .fa-layers-counter,
    .fa-layers-text {
        display: inline-block;
        position: absolute;
        text-align: center
    }

    .fa-layers {
        display: inline-block;
        height: 1em;
        position: relative;
        text-align: center;
        vertical-align: -.125em;
        width: 1em
    }

    .fa-layers svg.svg-inline--fa {
        -webkit-transform-origin: center center;
        transform-origin: center center
    }

    .fa-layers-text {
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        -webkit-transform-origin: center center;
        transform-origin: center center
    }

    .fa-layers-counter {
        background-color: var(--fa-counter-background-color, #ff253a);
        border-radius: var(--fa-counter-border-radius, 1em);
        box-sizing: border-box;
        color: var(--fa-inverse, #fff);
        line-height: var(--fa-counter-line-height, 1);
        max-width: var(--fa-counter-max-width, 5em);
        min-width: var(--fa-counter-min-width, 1.5em);
        overflow: hidden;
        padding: var(--fa-counter-padding, .25em .5em);
        right: var(--fa-right, 0);
        text-overflow: ellipsis;
        top: var(--fa-top, 0);
        -webkit-transform: scale(var(--fa-counter-scale, .25));
        transform: scale(var(--fa-counter-scale, .25));
        -webkit-transform-origin: top right;
        transform-origin: top right
    }

    .fa-layers-bottom-right {
        bottom: var(--fa-bottom, 0);
        right: var(--fa-right, 0);
        top: auto;
        -webkit-transform: scale(var(--fa-layers-scale, .25));
        transform: scale(var(--fa-layers-scale, .25));
        -webkit-transform-origin: bottom right;
        transform-origin: bottom right
    }

    .fa-layers-bottom-left {
        bottom: var(--fa-bottom, 0);
        left: var(--fa-left, 0);
        right: auto;
        top: auto;
        -webkit-transform: scale(var(--fa-layers-scale, .25));
        transform: scale(var(--fa-layers-scale, .25));
        -webkit-transform-origin: bottom left;
        transform-origin: bottom left
    }

    .fa-layers-top-right {
        top: var(--fa-top, 0);
        right: var(--fa-right, 0);
        -webkit-transform: scale(var(--fa-layers-scale, .25));
        transform: scale(var(--fa-layers-scale, .25));
        -webkit-transform-origin: top right;
        transform-origin: top right
    }

    .fa-layers-top-left {
        left: var(--fa-left, 0);
        right: auto;
        top: var(--fa-top, 0);
        -webkit-transform: scale(var(--fa-layers-scale, .25));
        transform: scale(var(--fa-layers-scale, .25));
        -webkit-transform-origin: top left;
        transform-origin: top left
    }

    .fa-1x {
        font-size: 1em
    }

    .fa-2x {
        font-size: 2em
    }

    .fa-3x {
        font-size: 3em
    }

    .fa-4x {
        font-size: 4em
    }

    .fa-5x {
        font-size: 5em
    }

    .fa-6x {
        font-size: 6em
    }

    .fa-7x {
        font-size: 7em
    }

    .fa-8x {
        font-size: 8em
    }

    .fa-9x {
        font-size: 9em
    }

    .fa-10x {
        font-size: 10em
    }

    .fa-2xs {
        font-size: .625em;
        line-height: .1em;
        vertical-align: .225em
    }

    .fa-xs {
        font-size: .75em;
        line-height: .0833333337em;
        vertical-align: .125em
    }

    .fa-sm {
        font-size: .875em;
        line-height: .0714285718em;
        vertical-align: .0535714295em
    }

    .fa-lg {
        font-size: 1.25em;
        line-height: .05em;
        vertical-align: -.075em
    }

    .fa-xl {
        font-size: 1.5em;
        line-height: .0416666682em;
        vertical-align: -.125em
    }

    .fa-2xl {
        font-size: 2em;
        line-height: .03125em;
        vertical-align: -.1875em
    }

    .fa-fw {
        text-align: center;
        width: 1.25em
    }

    .fa-ul {
        list-style-type: none;
        margin-left: var(--fa-li-margin, 2.5em);
        padding-left: 0
    }

    .fa-ul>li {
        position: relative
    }

    .fa-li {
        left: calc(var(--fa-li-width, 2em) * -1);
        position: absolute;
        text-align: center;
        width: var(--fa-li-width, 2em);
        line-height: inherit
    }

    .fa-border {
        border-color: var(--fa-border-color, #eee);
        border-radius: var(--fa-border-radius, .1em);
        border-style: var(--fa-border-style, solid);
        border-width: var(--fa-border-width, .08em);
        padding: var(--fa-border-padding, .2em .25em .15em)
    }

    .fa-pull-left {
        float: left;
        margin-right: var(--fa-pull-margin, .3em)
    }

    .fa-pull-right {
        float: right;
        margin-left: var(--fa-pull-margin, .3em)
    }

    .fa-beat {
        -webkit-animation-name: fa-beat;
        animation-name: fa-beat;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
        animation-timing-function: var(--fa-animation-timing, ease-in-out)
    }

    .fa-bounce {
        -webkit-animation-name: fa-bounce;
        animation-name: fa-bounce;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(.28, .84, .42, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(.28, .84, .42, 1))
    }

    .fa-fade {
        -webkit-animation-name: fa-fade;
        animation-name: fa-fade;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(.4, 0, .6, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(.4, 0, .6, 1))
    }

    .fa-beat-fade {
        -webkit-animation-name: fa-beat-fade;
        animation-name: fa-beat-fade;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(.4, 0, .6, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(.4, 0, .6, 1))
    }

    .fa-flip {
        -webkit-animation-name: fa-flip;
        animation-name: fa-flip;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
        animation-timing-function: var(--fa-animation-timing, ease-in-out)
    }

    .fa-shake {
        -webkit-animation-name: fa-shake;
        animation-name: fa-shake;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, linear);
        animation-timing-function: var(--fa-animation-timing, linear)
    }

    .fa-spin {
        -webkit-animation-name: fa-spin;
        animation-name: fa-spin;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 2s);
        animation-duration: var(--fa-animation-duration, 2s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, linear);
        animation-timing-function: var(--fa-animation-timing, linear)
    }

    .fa-spin-reverse {
        --fa-animation-direction: reverse
    }

    .fa-pulse,
    .fa-spin-pulse {
        -webkit-animation-name: fa-spin;
        animation-name: fa-spin;
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, steps(8));
        animation-timing-function: var(--fa-animation-timing, steps(8))
    }

    @media (prefers-reduced-motion:reduce) {

        .fa-beat,
        .fa-beat-fade,
        .fa-bounce,
        .fa-fade,
        .fa-flip,
        .fa-pulse,
        .fa-shake,
        .fa-spin,
        .fa-spin-pulse {
            -webkit-animation-delay: -1ms;
            animation-delay: -1ms;
            -webkit-animation-duration: 1ms;
            animation-duration: 1ms;
            -webkit-animation-iteration-count: 1;
            animation-iteration-count: 1;
            -webkit-transition-delay: 0s;
            transition-delay: 0s;
            -webkit-transition-duration: 0s;
            transition-duration: 0s
        }
    }

    @-webkit-keyframes fa-beat {

        0%,
        90% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        45% {
            -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25))
        }
    }

    @keyframes fa-beat {

        0%,
        90% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        45% {
            -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25))
        }
    }

    @-webkit-keyframes fa-bounce {
        0% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }

        10% {
            -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, .9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, .9)) translateY(0)
        }

        30% {
            -webkit-transform: scale(var(--fa-bounce-jump-scale-x, .9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, .9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -.5em))
        }

        50% {
            -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, .95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, .95)) translateY(0)
        }

        57% {
            -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -.125em))
        }

        64% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }

        100% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }
    }

    @keyframes fa-bounce {
        0% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }

        10% {
            -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, .9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, .9)) translateY(0)
        }

        30% {
            -webkit-transform: scale(var(--fa-bounce-jump-scale-x, .9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, .9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -.5em))
        }

        50% {
            -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, .95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, .95)) translateY(0)
        }

        57% {
            -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -.125em))
        }

        64% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }

        100% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0)
        }
    }

    @-webkit-keyframes fa-fade {
        50% {
            opacity: var(--fa-fade-opacity, .4)
        }
    }

    @keyframes fa-fade {
        50% {
            opacity: var(--fa-fade-opacity, .4)
        }
    }

    @-webkit-keyframes fa-beat-fade {

        0%,
        100% {
            opacity: var(--fa-beat-fade-opacity, .4);
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        50% {
            opacity: 1;
            -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125))
        }
    }

    @keyframes fa-beat-fade {

        0%,
        100% {
            opacity: var(--fa-beat-fade-opacity, .4);
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        50% {
            opacity: 1;
            -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125))
        }
    }

    @-webkit-keyframes fa-flip {
        50% {
            -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg))
        }
    }

    @keyframes fa-flip {
        50% {
            -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg))
        }
    }

    @-webkit-keyframes fa-shake {
        0% {
            -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg)
        }

        4% {
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg)
        }

        24%,
        8% {
            -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg)
        }

        12%,
        28% {
            -webkit-transform: rotate(18deg);
            transform: rotate(18deg)
        }

        16% {
            -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg)
        }

        20% {
            -webkit-transform: rotate(22deg);
            transform: rotate(22deg)
        }

        32% {
            -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg)
        }

        36% {
            -webkit-transform: rotate(12deg);
            transform: rotate(12deg)
        }

        100%,
        40% {
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }
    }

    @keyframes fa-shake {
        0% {
            -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg)
        }

        4% {
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg)
        }

        24%,
        8% {
            -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg)
        }

        12%,
        28% {
            -webkit-transform: rotate(18deg);
            transform: rotate(18deg)
        }

        16% {
            -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg)
        }

        20% {
            -webkit-transform: rotate(22deg);
            transform: rotate(22deg)
        }

        32% {
            -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg)
        }

        36% {
            -webkit-transform: rotate(12deg);
            transform: rotate(12deg)
        }

        100%,
        40% {
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }
    }

    @-webkit-keyframes fa-spin {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @keyframes fa-spin {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    .fa-rotate-90 {
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg)
    }

    .fa-rotate-180 {
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg)
    }

    .fa-rotate-270 {
        -webkit-transform: rotate(270deg);
        transform: rotate(270deg)
    }

    .fa-flip-horizontal {
        -webkit-transform: scale(-1, 1);
        transform: scale(-1, 1)
    }

    .fa-flip-vertical {
        -webkit-transform: scale(1, -1);
        transform: scale(1, -1)
    }

    .fa-flip-both,
    .fa-flip-horizontal.fa-flip-vertical {
        -webkit-transform: scale(-1, -1);
        transform: scale(-1, -1)
    }

    .fa-rotate-by {
        -webkit-transform: rotate(var(--fa-rotate-angle, 0));
        transform: rotate(var(--fa-rotate-angle, 0))
    }

    .fa-stack {
        display: inline-block;
        vertical-align: middle;
        height: 2em;
        position: relative;
        width: 2.5em
    }

    .fa-stack-1x,
    .fa-stack-2x {
        bottom: 0;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
        z-index: var(--fa-stack-z-index, auto)
    }

    .svg-inline--fa.fa-stack-1x {
        height: 1em;
        width: 1.25em
    }

    .svg-inline--fa.fa-stack-2x {
        height: 2em;
        width: 2.5em
    }

    .fa-inverse {
        color: var(--fa-inverse, #fff)
    }

    .fa-sr-only,
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0
    }

    .fa-sr-only-focusable:not(:focus),
    .sr-only-focusable:not(:focus) {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0
    }

    .svg-inline--fa .fa-primary {
        fill: var(--fa-primary-color, currentColor);
        opacity: var(--fa-primary-opacity, 1)
    }

    .svg-inline--fa .fa-secondary {
        fill: var(--fa-secondary-color, currentColor);
        opacity: var(--fa-secondary-opacity, .4)
    }

    .svg-inline--fa.fa-swap-opacity .fa-primary {
        opacity: var(--fa-secondary-opacity, .4)
    }

    .svg-inline--fa.fa-swap-opacity .fa-secondary {
        opacity: var(--fa-primary-opacity, 1)
    }

    .svg-inline--fa mask .fa-primary,
    .svg-inline--fa mask .fa-secondary {
        fill: #000
    }

    .fa-duotone.fa-inverse,
    .fad.fa-inverse {
        color: var(--fa-inverse, #fff)
    }
</style>
<style>
    .customer-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    .social-icons a {
        margin-right: 10px;
        color: #6c757d;
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
    .paid {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    .cancelled {
        background-color: #f8d7da;
        color: #842029;
    }
    .pending {
        background-color: #fff3cd;
        color: #664d03;
    }
    .fulfilled {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    .ready {
        background-color: #cfe2ff;
        color: #084298;
    }
    .partial {
        background-color: #fff3cd;
        color: #664d03;
    }
    .delivery-delayed {
        background-color: #f8d7da;
        color: #842029;
    }
    .rating-stars {
        color: #ffc107;
    }
    .rating-gray {
        color: #e0e0e0;
    }
    .divider {
        border-top: 1px dashed #dee2e6;
        margin: 20px 0;
    }
    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .actions-dropdown .dropdown-item {
        font-size: 0.9rem;
        padding: 0.4rem 1rem;
    }
    .stat-box {
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        background-color: #f8f9fa;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .note-card {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 10px;
        margin-bottom: 10px;
    }
    .note-date {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .note-user {
        font-size: 0.8rem;
        font-weight: bold;
    }
    .page-link {
        color: #0d6efd;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    .page-link.active {
        z-index: 3;
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .view-all {
        font-size: 0.8rem;
        color: #0d6efd;
    }
    .wishlist-item, .review-item {
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .wishlist-item:last-child, .review-item:last-child {
        border-bottom: none;
    }
    .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }
</style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">










        <div class="content">
            <div class="container mt-3 mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">Chi tiết khách hàng</h1>
                    <div>
                        <button class="btn btn-outline-danger btn-sm me-2">
                            <i class="fas fa-trash-alt me-1"></i> Xóa khách hàng
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-key me-1"></i> Đặt lại mật khẩu
                        </button>
                    </div>
                </div>
        
                <div class="row">
                    <!-- Cột trái - Thông tin khách hàng -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="/api/placeholder/100/100" alt="Ảnh đại diện khách hàng" class="customer-avatar mb-2">
                                    <h5 class="mb-0">Ansolo Lazinatov</h5>
                                    <p class="text-muted small">Tham gia 3 tháng trước</p>
                                    <div class="social-icons">
                                        <a href="#"><i class="fab fa-linkedin"></i></a>
                                        <a href="#"><i class="fab fa-facebook"></i></a>
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                    </div>
                                </div>
                                
                                <div class="row text-center mb-3">
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">297</div>
                                            <div class="stat-label">Theo dõi</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">56</div>
                                            <div class="stat-label">Dự án</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">97</div>
                                            <div class="stat-label">Hoàn thành</div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="divider"></div>
                                
                                <!-- Địa chỉ mặc định -->
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Địa chỉ mặc định</h6>
                                    <button class="btn btn-link btn-sm p-0"><i class="fas fa-edit"></i></button>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1 fw-bold">Địa chỉ</p>
                                    <p class="mb-0">Shatinon Mellian</p>
                                    <p class="mb-0">Vancouver, British Columbia</p>
                                    <p class="mb-0">Canada</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="mb-1 fw-bold">Email</p>
                                    <p class="mb-0"><a href="mailto:shatinon@jaemail.com" class="text-decoration-none">shatinon@jaemail.com</a></p>
                                </div>
                                
                                <div>
                                    <p class="mb-1 fw-bold">Điện thoại</p>
                                    <p class="mb-0">+1234567890</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phân loại khách hàng -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Phân loại khách hàng</h6>
                                    <button class="btn btn-link btn-sm p-0"><i class="fas fa-plus"></i></button>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <span class="badge bg-primary me-2 mb-2">Khách VIP</span>
                                    {{-- <span class="badge bg-info me-2 mb-2">Đam mê công nghệ</span>
                                    <span class="badge bg-success me-2 mb-2">Mua sắm thường xuyên</span> --}}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lịch sử hoạt động -->
                        <div class="card">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Lịch sử hoạt động</h6>
                                    <a href="#" class="view-all">Xem tất cả</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-shopping-cart text-primary me-2"></i>
                                                Đặt đơn hàng #2453
                                            </div>
                                            <small class="text-muted">Hôm nay</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                Thêm sản phẩm vào danh sách yêu thích
                                            </div>
                                            <small class="text-muted">Hôm qua</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-star text-warning me-2"></i>
                                                Đánh giá sản phẩm
                                            </div>
                                            <small class="text-muted">3 ngày trước</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cột phải - Đơn hàng, Danh sách yêu thích, Đánh giá -->
                    <div class="col-lg-8">
                        <!-- Đơn hàng -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h5 class="card-title mb-0">Đơn hàng (97)</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="ordersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-filter me-1"></i> Lọc
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="ordersDropdown">
                                            <li><a class="dropdown-item" href="#">Tất cả đơn hàng</a></li>
                                            <li><a class="dropdown-item" href="#">Đơn hàng đã hoàn thành</a></li>
                                            <li><a class="dropdown-item" href="#">Đơn hàng đang xử lý</a></li>
                                            <li><a class="dropdown-item" href="#">Đơn hàng đã hủy</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    ĐƠN HÀNG #
                                                    <i class="fas fa-sort ms-1 text-muted"></i>
                                                </th>
                                                <th scope="col">
                                                    TỔNG TIỀN
                                                    <i class="fas fa-sort ms-1 text-muted"></i>
                                                </th>
                                                <th scope="col">
                                                    TRẠNG THÁI THANH TOÁN
                                                    <i class="fas fa-sort ms-1 text-muted"></i>
                                                </th>
                                                <th scope="col">
                                                    TRẠNG THÁI THỰC HIỆN
                                                    <i class="fas fa-sort ms-1 text-muted"></i>
                                                </th>
                                                <th scope="col">
                                                    LOẠI GIAO HÀNG
                                                    <i class="fas fa-sort ms-1 text-muted"></i>
                                                </th>
                                                <th scope="col">
                                                    NGÀY
                                                    <i class="fas fa-sort-down ms-1"></i>
                                                </th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2453</a></td>
                                                <td>87.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge fulfilled">ĐÃ HOÀN THÀNH</span></td>
                                                <td>Tiền mặt khi nhận hàng</td>
                                                <td>12/12, 12:56</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2452</a></td>
                                                <td>2.784.000₫</td>
                                                <td><span class="badge status-badge cancelled">ĐÃ HỦY</span></td>
                                                <td><span class="badge status-badge ready">SẴN SÀNG LẤY HÀNG</span></td>
                                                <td>Miễn phí vận chuyển</td>
                                                <td>09/12, 14:28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2451</a></td>
                                                <td>375.000₫</td>
                                                <td><span class="badge status-badge pending">ĐANG XỬ LÝ</span></td>
                                                <td><span class="badge status-badge partial">HOÀN THÀNH MỘT PHẦN</span></td>
                                                <td>Nhận tại cửa hàng</td>
                                                <td>04/12, 12:56</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2450</a></td>
                                                <td>557.000₫</td>
                                                <td><span class="badge status-badge cancelled">ĐÃ HỦY</span></td>
                                                <td><span class="badge status-badge cancelled">ĐƠN HÀNG ĐÃ HỦY</span></td>
                                                <td>Vận chuyển tiêu chuẩn</td>
                                                <td>01/12, 04:07</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2449</a></td>
                                                <td>9.562.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge fulfilled">ĐÃ HOÀN THÀNH</span></td>
                                                <td>Chuyển phát nhanh</td>
                                                <td>28/11, 19:28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2448</a></td>
                                                <td>46.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge delivery-delayed">GIAO HÀNG CHẬM</span></td>
                                                <td>Giao hàng tận nơi</td>
                                                <td>24/11, 10:16</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2448</a></td>
                                                <td>46.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge delivery-delayed">GIAO HÀNG CHẬM</span></td>
                                                <td>Giao hàng tận nơi</td>
                                                <td>24/11, 10:16</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a></li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a></li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">1 đến 6 trên tổng số 15</div>
                                    <div>
                                        <a href="#" class="view-all">Xem tất cả <i class="fas fa-chevron-right ms-1"></i></a>
                                    </div>
                                </div>
                                
                                <nav class="mt-3" aria-label="Phân trang đơn hàng">
                                    <ul class="pagination pagination-sm justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Trước">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Sau">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                       
           
        </div>
        <div class="row">
             <!-- Danh sách yêu thích -->
             <div class="card mb-">
                <div class="card-body">
                    <div class="section-heading">
                        <h5 class="card-title mb-0">Danh sách yêu thích (43)</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="wishlistDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="wishlistDropdown">
                                <li><a class="dropdown-item" href="#">Xuất danh sách</a></li>
                                <li><a class="dropdown-item" href="#">Gửi khuyến mãi</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">
                                        SẢN PHẨM
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th scope="col">
                                        MÀU SẮC
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th scope="col">
                                        KÍCH THƯỚC
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th scope="col">
                                        GIÁ
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th scope="col">
                                        TỔNG
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="/api/placeholder/40/40" alt="Sản phẩm" class="img-thumbnail" width="40"></td>
                                    <td class="product-title">Đồng hồ thông minh Fitbit Sense Advanced</td>
                                    <td>Đen mờ</td>
                                    <td>42</td>
                                    <td>1.150.000₫</td>
                                    <td>1.150.000₫</td>
                                </tr>
                                <tr>
                                    <td><img src="/api/placeholder/40/40" alt="Sản phẩm" class="img-thumbnail" width="40"></td>
                                    <td class="product-title">iPad Pro 12.9-inch 2023 Wi-Fi + Cellular</td>
                                    <td>Đen</td>
                                    <td>Pro</td>
                                    <td>29.990.000₫</td>
                                    <td>29.990.000₫</td>
                                </tr>
                                <tr>
                                    <td><img src="/api/placeholder/40/40" alt="Sản phẩm" class="img-thumbnail" width="40"></td>
                                    <td class="product-title">Tay cầm không dây PlayStation 5 DualSense</td>
                                    <td>Trắng</td>
                                    <td>Tiêu chuẩn</td>
                                    <td>1.790.000₫</td>
                                    <td>1.790.000₫</td>
                                </tr>
                                <tr>
                                    <td><img src="/api/placeholder/40/40" alt="Sản phẩm" class="img-thumbnail" width="40"></td>
                                    <td class="product-title">MacBook Pro 13 inch M1 8C256G</td>
                                    <td>Xám không gian</td>
                                    <td>Pro</td>
                                    <td>29.990.000₫</td>
                                    <td>29.990.000₫</td>
                                </tr>
                                <tr>
                                    <td><img src="/api/placeholder/40/40" alt="Sản phẩm" class="img-thumbnail" width="40"></td>
                                    <td class="product-title">Apple iMac 24" 4K Retina Display M1 8C</td>
                                    <td>Xanh dương</td>
                                    <td>21"</td>
                                    <td>1.790.000₫</td>
                                    <td>1.790.000₫</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">1 đến 5 trên tổng số 9</div>
                        <div>
                            <a href="#" class="view-all">Xem tất cả <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                    
                    <nav class="mt-3" aria-label="Phân trang danh sách yêu thích">
                        <ul class="pagination pagination-sm justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Trước">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Sau">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <!-- Ratings & Reviews -->
            {{-- rating --}}
                    <div>
                        <h3 class="mb-4">Ratings &amp; reviews <span
                                class="text-body-tertiary fw-normal">(43)</span></h3>
                        <div class="border-top border-bottom border-translucent" id="customerRatingsTable"
                            data-list="{&quot;valueNames&quot;:[&quot;product&quot;,&quot;rating&quot;,&quot;review&quot;,&quot;status&quot;,&quot;date&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                            <div class="table-responsive scrollbar">
                                <table class="table fs-9 mb-0">
                                    <thead>
                                        <tr>
                                            <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                                style="width:20%;" data-sort="product">PRODUCT</th>
                                            <th class="sort align-middle" scope="col" data-sort="rating"
                                                style="width:10%;">RATING</th>
                                            <th class="sort align-middle" scope="col" style="width:50%;"
                                                data-sort="review">REVIEW</th>
                                            <th class="sort text-end align-middle" scope="col" style="width:10%;"
                                                data-sort="status">STATUS</th>
                                            <th class="sort text-end align-middle" scope="col" style="width:10%;"
                                                data-sort="date">DATE</th>
                                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="customer-rating-table-body">
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                                    href="../../../apps/e-commerce/landing/product-details.html">Apple
                                                    Magic Mouse (Wireless, Rech...</a></td>
                                            <td class="align-middle rating white-space-nowrap fs-10"><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                                            </td>
                                            <td class="align-middle review" style="min-width:350px;">
                                                <p class="fw-semibold text-body-highlight mb-0">It's lovely, works
                                                    right out of the box (as you'd expect from an Apple device), and
                                                    has a number of useful functions.</p>
                                            </td>
                                            <td class="align-middle text-end status"><span
                                                    class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                        class="badge-label">Success</span><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16px"
                                                        height="16px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-check ms-1"
                                                        style="height:12.8px;width:12.8px;">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg></span></td>
                                            <td class="align-middle text-end date white-space-nowrap">
                                                <p class="text-body-tertiary mb-0">Just now</p>
                                            </td>
                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="btn-reveal-trigger position-static"><button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent"><svg
                                                            class="svg-inline--fa fa-ellipsis fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="ellipsis" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                            class="dropdown-item" href="#!">View</a><a
                                                            class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a
                                                            class="dropdown-item text-danger"
                                                            href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap"><a
                                                    class="fw-semibold"
                                                    href="../../../apps/e-commerce/landing/product-details.html">Fitbit
                                                    Sense Advanced Smartwatch ...</a></td>
                                            <td class="align-middle rating white-space-nowrap fs-10"><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                                            </td>
                                            <td class="align-middle review" style="min-width:350px;">
                                                <p class="fw-semibold text-body-highlight mb-0">This is an
                                                    exceptional smartwatch, featuring a wealth of useful functions
                                                    at an affordable price. The watch is small ...<a
                                                        href="#!">See
                                                        more</a></p>
                                            </td>
                                            <td class="align-middle text-end status"><span
                                                    class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                        class="badge-label">Success</span><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16px"
                                                        height="16px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-check ms-1"
                                                        style="height:12.8px;width:12.8px;">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg></span></td>
                                            <td class="align-middle text-end date white-space-nowrap">
                                                <p class="text-body-tertiary mb-0">Dec 9, 2:28PM</p>
                                            </td>
                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="btn-reveal-trigger position-static"><button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent"><svg
                                                            class="svg-inline--fa fa-ellipsis fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="ellipsis" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                            class="dropdown-item" href="#!">View</a><a
                                                            class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a
                                                            class="dropdown-item text-danger"
                                                            href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap"><a
                                                    class="fw-semibold"
                                                    href="../../../apps/e-commerce/landing/product-details.html">HORI
                                                    Racing Wheel Apex for PlaySt...</a></td>
                                            <td class="align-middle rating white-space-nowrap fs-10"><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                                            </td>
                                            <td class="align-middle review" style="min-width:350px;">
                                                <p class="fw-semibold text-body-highlight mb-0">This steering wheel
                                                    is a great buy! It works well and feels good, however I wish it
                                                    had a wider diameter like a real ...<a href="#!">See more</a>
                                                </p>
                                            </td>
                                            <td class="align-middle text-end status"><span
                                                    class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                                        class="badge-label">Pending</span><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16px"
                                                        height="16px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-alert-octagon ms-1"
                                                        style="height:12.8px;width:12.8px;">
                                                        <polygon
                                                            points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                                        </polygon>
                                                        <line x1="12" y1="8" x2="12"
                                                            y2="12"></line>
                                                        <line x1="12" y1="16" x2="12.01"
                                                            y2="16"></line>
                                                    </svg></span></td>
                                            <td class="align-middle text-end date white-space-nowrap">
                                                <p class="text-body-tertiary mb-0">Dec 4, 12:56 PM</p>
                                            </td>
                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="btn-reveal-trigger position-static"><button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent"><svg
                                                            class="svg-inline--fa fa-ellipsis fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="ellipsis" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                            class="dropdown-item" href="#!">View</a><a
                                                            class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a
                                                            class="dropdown-item text-danger"
                                                            href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap"><a
                                                    class="fw-semibold"
                                                    href="../../../apps/e-commerce/landing/product-details.html">Razer
                                                    Kraken v3 x Wired 7.1 Surro...</a></td>
                                            <td class="align-middle rating white-space-nowrap fs-10"><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                                            </td>
                                            <td class="align-middle review" style="min-width:350px;">
                                                <p class="fw-semibold text-body-highlight mb-0">My son says these
                                                    are the greatest he's ever tasted.</p>
                                            </td>
                                            <td class="align-middle text-end status"><span
                                                    class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span
                                                        class="badge-label">Cancelled</span><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16px"
                                                        height="16px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-x ms-1"
                                                        style="height:12.8px;width:12.8px;">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg></span></td>
                                            <td class="align-middle text-end date white-space-nowrap">
                                                <p class="text-body-tertiary mb-0">Nov 28, 7:28 PM</p>
                                            </td>
                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="btn-reveal-trigger position-static"><button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent"><svg
                                                            class="svg-inline--fa fa-ellipsis fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="ellipsis" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                            class="dropdown-item" href="#!">View</a><a
                                                            class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a
                                                            class="dropdown-item text-danger"
                                                            href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap"><a
                                                    class="fw-semibold"
                                                    href="../../../apps/e-commerce/landing/product-details.html">iPhone
                                                    13 pro max-Pacific Blue-12...</a></td>
                                            <td class="align-middle rating white-space-nowrap fs-10"><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="star"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                    </path>
                                                </svg><!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com --><svg
                                                    class="svg-inline--fa fa-star text-warning-light"
                                                    data-bs-theme="light" aria-hidden="true" focusable="false"
                                                    data-prefix="far" data-icon="star" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                    </path>
                                                </svg><!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                                            </td>
                                            <td class="align-middle review" style="min-width:350px;">
                                                <p class="fw-semibold text-body-highlight mb-0">I chose wisely. The
                                                    phone is in excellent condition, with no scratches or dents,
                                                    excellent battery life, and flawless...<a href="#!">See
                                                        more</a>
                                                </p>
                                            </td>
                                            <td class="align-middle text-end status"><span
                                                    class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                        class="badge-label">Success</span><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16px"
                                                        height="16px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-check ms-1"
                                                        style="height:12.8px;width:12.8px;">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg></span></td>
                                            <td class="align-middle text-end date white-space-nowrap">
                                                <p class="text-body-tertiary mb-0">Nov 24, 10:16 AM</p>
                                            </td>
                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="btn-reveal-trigger position-static"><button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                        type="button" data-bs-toggle="dropdown"
                                                        data-boundary="window" aria-haspopup="true"
                                                        aria-expanded="false" data-bs-reference="parent"><svg
                                                            class="svg-inline--fa fa-ellipsis fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="ellipsis" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                            class="dropdown-item" href="#!">View</a><a
                                                            class="dropdown-item" href="#!">Export</a>
                                                        <div class="dropdown-divider"></div><a
                                                            class="dropdown-item text-danger"
                                                            href="#!">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                                <div class="col-auto d-flex">
                                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body"
                                        data-list-info="data-list-info">1 to 5 <span class="text-body-tertiary">
                                            Items of </span>10</p><a class="fw-semibold" href="#!"
                                        data-list-view="*">View all<svg class="svg-inline--fa fa-angle-right ms-1"
                                            data-fa-transform="down-1" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="angle-right" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                            data-fa-i2svg="" style="transform-origin: 0.3125em 0.5625em;">
                                            <g transform="translate(160 256)">
                                                <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"
                                                        transform="translate(-160 -256)"></path>
                                                </g>
                                            </g>
                                        </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com --></a><a
                                        class="fw-semibold d-none" href="#!" data-list-view="less">View
                                        Less<svg class="svg-inline--fa fa-angle-right ms-1"
                                            data-fa-transform="down-1" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="angle-right" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                            data-fa-i2svg="" style="transform-origin: 0.3125em 0.5625em;">
                                            <g transform="translate(160 256)">
                                                <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"
                                                        transform="translate(-160 -256)"></path>
                                                </g>
                                            </g>
                                        </svg><!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com --></a>
                                </div>
                                <div class="col-auto d-flex"><button class="page-link disabled"
                                        data-list-pagination="prev" disabled=""><svg
                                            class="svg-inline--fa fa-chevron-left" aria-hidden="true"
                                            focusable="false" data-prefix="fas" data-icon="chevron-left"
                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 320 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z">
                                            </path>
                                        </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                                    <ul class="mb-0 pagination">
                                        <li class="active"><button class="page" type="button" data-i="1"
                                                data-page="5">1</button></li>
                                        <li><button class="page" type="button" data-i="2"
                                                data-page="5">2</button>
                                        </li>
                                    </ul><button class="page-link pe-0" data-list-pagination="next"><svg
                                            class="svg-inline--fa fa-chevron-right" aria-hidden="true"
                                            focusable="false" data-prefix="fas" data-icon="chevron-right"
                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 320 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                                            </path>
                                        </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>


    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
<script>
    var navbarTopShape = window.config.config.phoenixNavbarTopShape;
    var navbarPosition = window.config.config.phoenixNavbarPosition;
    var body = document.querySelector('body');
    var navbarDefault = document.querySelector('#navbarDefault');
    var navbarTop = document.querySelector('#navbarTop');
    var topNavSlim = document.querySelector('#topNavSlim');
    var navbarTopSlim = document.querySelector('#navbarTopSlim');
    var navbarCombo = document.querySelector('#navbarCombo');
    var navbarComboSlim = document.querySelector('#navbarComboSlim');
    var dualNav = document.querySelector('#dualNav');

    var documentElement = document.documentElement;
    var navbarVertical = document.querySelector('.navbar-vertical');

    if (navbarPosition === 'dual-nav') {
        topNavSlim?.remove();
        navbarTop?.remove();
        navbarTopSlim?.remove();
        navbarCombo?.remove();
        navbarComboSlim?.remove();
        navbarDefault?.remove();
        navbarVertical?.remove();
        dualNav.removeAttribute('style');
        document.documentElement.setAttribute('data-navigation-type', 'dual');

    } else if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
        navbarDefault?.remove();
        navbarTop?.remove();
        navbarTopSlim?.remove();
        navbarCombo?.remove();
        navbarComboSlim?.remove();
        topNavSlim.style.display = 'block';
        navbarVertical.style.display = 'inline-block';
        document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');

    } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
        navbarDefault?.remove();
        navbarVertical?.remove();
        navbarTop?.remove();
        topNavSlim?.remove();
        navbarCombo?.remove();
        navbarComboSlim?.remove();
        dualNav?.remove();
        navbarTopSlim.removeAttribute('style');
        document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');
    } else if (navbarTopShape === 'slim' && navbarPosition === 'combo') {
        navbarDefault?.remove();
        navbarTop?.remove();
        topNavSlim?.remove();
        navbarCombo?.remove();
        navbarTopSlim?.remove();
        dualNav?.remove();
        navbarComboSlim.removeAttribute('style');
        navbarVertical.removeAttribute('style');
        document.documentElement.setAttribute('data-navbar-horizontal-shape', 'slim');
    } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
        navbarDefault?.remove();
        topNavSlim?.remove();
        navbarVertical?.remove();
        navbarTopSlim?.remove();
        navbarCombo?.remove();
        navbarComboSlim?.remove();
        dualNav?.remove();
        navbarTop.removeAttribute('style');
        document.documentElement.setAttribute('data-navigation-type', 'horizontal');
    } else if (navbarTopShape === 'default' && navbarPosition === 'combo') {
        topNavSlim?.remove();
        navbarTop?.remove();
        navbarTopSlim?.remove();
        navbarDefault?.remove();
        navbarComboSlim?.remove();
        dualNav?.remove();
        navbarCombo.removeAttribute('style');
        navbarVertical.removeAttribute('style');
        document.documentElement.setAttribute('data-navigation-type', 'combo');
    } else {
        topNavSlim?.remove();
        navbarTop?.remove();
        navbarTopSlim?.remove();
        navbarCombo?.remove();
        navbarComboSlim?.remove();
        dualNav?.remove();
        navbarDefault.removeAttribute('style');
        navbarVertical.removeAttribute('style');
    }

    var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
    var navbarTop = document.querySelector('.navbar-top');
    if (navbarTopStyle === 'darker') {
        navbarTop.setAttribute('data-navbar-appearance', 'darker');
    }

    var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
    var navbarVertical = document.querySelector('.navbar-vertical');
    if (navbarVerticalStyle === 'darker') {
        navbarVertical.setAttribute('data-navbar-appearance', 'darker');
    }
</script>
@endpush
