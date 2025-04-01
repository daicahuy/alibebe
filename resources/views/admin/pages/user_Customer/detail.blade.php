@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .wishlist-item,
        .review-item {
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .wishlist-item:last-child,
        .review-item:last-child {
            border-bottom: none;
        }

        .product-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }
    </style>

    <style>
        .card-header {
            background-color: #f8f9fa;
        }

        .progress-bar-custom {
            background-color: #28a745;
        }

        .badge-custom {
            font-size: 0.9em;
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

                    <div class="col-auto">
                        <h2 class="mb-0">Chi tiết khách hàng</h2>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-outline-danger btn-sm me-2">
                            <i class="fas fa-trash-alt me-1"></i> Xóa khách hàng
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-key me-1"></i> Đặt lại mật khẩu
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    @if ($data['user']->avatar == null)
                                        <td class="cursor-pointer">
                                            <div class="user-round">
                                                <h4>{{ strtoupper(substr($data['user']->fullname, 0, 1)) }}</h4>
                                            </div>
                                        </td>
                                    @else
                                        <img src="{{ Storage::url($data['user']->avatar) }}" alt="Ảnh đại diện khách hàng"
                                            class="customer-avatar mb-2">
                                    @endif

                                    <h5 class="mb-0">{{ $data['user']->fullname }}</h5>
                                    <p class="text-muted small">Tham gia: {{ $data['accountCreatedAt'] }} </p>
                                    <div class="social-icons">
                                        <a href="#"><i class="fab fa-linkedin"></i></a>
                                        <a href="#"><i class="fab fa-facebook"></i></a>
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                    </div>
                                </div>

                                <div class="row text-center mb-3">
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">{{ $data['countOrder']['allCount'] }}
                                            </div>
                                            <div class="stat-label">Đơn hàng</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">{{ $data['countOrder']['successCount'] }}
                                            </div>
                                            <div class="stat-label">Thành công</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">{{ $data['countOrder']['cancelCount'] }}
                                            </div>
                                            <div class="stat-label">Hủy</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="divider"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card mb-6">
                            <div class="card-body">


                                <!-- Địa chỉ mặc định -->
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Địa chỉ mặc định</h6>
                                    <button class="btn btn-link btn-sm p-0"><i class="fas fa-edit"></i></button>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1 fw-bold">Địa chỉ</p>
                                    <p>{{ $data['defaultAddress']->address ?? 'Người dùng chưa cập nhật' }}</p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 fw-bold">Email</p>
                                    <p class="mb-0"><a href="mailto:shatinon@jaemail.com"
                                            class="text-decoration-none">{{ $data['user']->email ?? 'Người dùng chưa cập nhật' }}</a>
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-1 fw-bold">Điện thoại</p>
                                    <p class="mb-0">
                                        {{ $data['defaultAddress']->phone_number ?? 'Người dùng chưa cập nhật' }}</p>
                                </div>
                            </div>
                        </div>




                    </div>

                    {{-- <div class="col-lg-4">
                        <!-- Phân loại khách hàng -->
                       
                    </div> --}}

                    <div class="col-lg-6">
                        <!-- Lịch sử hoạt động -->
                        <div class="card mb-6">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Lịch sử hoạt động</h6>
                                    {{-- <a href="#" class="view-all">Xem tất cả</a> --}}
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-shopping-cart text-primary me-2"></i>
                                                Đặt đơn hàng
                                            </div>
                                            <small
                                                class="text-muted">{{ $data['lastOrderTime'] ?? 'Chưa có hoạt động' }}</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                Thêm sản phẩm yêu thích
                                            </div>
                                            <small
                                                class="text-muted">{{ $data['lastWishlistTime'] ?? 'Chưa có hoạt động' }}</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-star text-warning me-2"></i>
                                                Đánh giá sản phẩm
                                            </div>
                                            <small
                                                class="text-muted">{{ $data['lastReviewTime'] ?? 'Chưa có hoạt động' }}</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            {{-- </div> --}}
                            {{-- <div class="card mb-6"> --}}
                            <br>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">

                                    <div class="card-mb-3">
                                        <div class="section-heading">
                                            <h6 class="card-subtitle mb-0">Phân loại khách hàng</h6>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewRank"
                                                class="mx-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>

                                        <div class="d-flex flex-wrap">
                                            <span class="badge bg-primary me-2 mb-2">{{ $data['userRank'] }}</span>
                                        </div>
                                    </div>

                                    <div class="card-mb-3">
                                        <div class="section-heading">
                                            <h6 class="card-subtitle mb-0">Trạng thái tài khoản</h6>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            @if ($data['user']->status == 0)
                                                <span class="badge bg-warning me-2 mb-2">Không hoạt động</span>
                                            @elseif ($data['user']->status == 1)
                                                <span class="badge bg-primary me-2 mb-2">Hoạt động</span>
                                            @elseif ($data['user']->status == 2)
                                                <span class="badge bg-danger me-2 mb-2">Bị khóa</span>
                                            @else
                                                <span class="badge bg-dark me-2 mb-2">Không xác định</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cột phải - Đơn hàng, Danh sách yêu thích, Đánh giá -->
                    <div class="col-lg-8">




                    </div>

                    {{-- nhân viên --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">
                                        <i class="fas fa-chart-line me-2"></i>Báo Cáo Chi Tiết
                                    </h4>
                                    <div class="filter-container">
                                        <form method="GET"
                                            action="{{ route('admin.users.customer.detail', $data['user']->id) }}"
                                            class="d-flex justify-content-evenly align-items-end flex-wrap gap-3 w-100">
                                            <!-- Start Date -->
                                            <div class="flex-grow-1">
                                                <label for="startDate" class="form-label fw-bold mb-0">Ngày bắt
                                                    đầu</label>
                                                <input type="date" id="startDate" name="startDate"
                                                    value="{{ request('startDate', now()->toDateString()) }}"
                                                    class="form-control">
                                            </div>

                                            <!-- End Date -->
                                            <div class="flex-grow-1">
                                                <label for="endDate" class="form-label fw-bold mb-0">Ngày kết
                                                    thúc</label>
                                                <input type="date" id="endDate" name="endDate"
                                                    value="{{ request('endDate', now()->toDateString()) }}"
                                                    class="form-control">
                                            </div>

                                            <!-- Filter & Reset Buttons -->
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-theme">Lọc</button>
                                                <a href="{{ route('admin.users.customer.detail', $data['user']->id) }}"
                                                    class="btn btn-secondary">Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Tổng Quan Đơn Hàng</div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span>Tổng Số Đơn</span>
                                                        <strong
                                                            class="text-primary">{{ $data['order']['countAllDetail'] }}</strong>
                                                    </div>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar progress-bar-custom" role="progressbar"
                                                            style="width: {{ $data['percentCountSuccess'] }}%"
                                                            aria-valuenow="{{ $data['percentCountSuccess'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">Hoàn Thành
                                                            {{ $data['percentCountSuccess'] }}%</div>
                                                    </div>
                                                    <div class="mt-2">
                                                        {{-- @dd($data) --}}
                                                        <small class="text-muted">Chi Tiết Trạng Thái</small>
                                                        <div class="d-flex justify-content-between mt-1">
                                                            <span class="badge bg-success badge-custom">Thành Công:
                                                                {{ $data['order']['countSuccessDetail'] }}</span>
                                                            <span class="badge bg-warning badge-custom">Đang Xử Lý:
                                                                {{ $data['order']['countProcessingDetail'] }}</span>
                                                            <span class="badge bg-danger badge-custom">Hủy:
                                                                {{ $data['order']['countCancelDetail'] }}</span>
                                                            <span class="badge bg-dark badge-custom">Hoàn hàng:
                                                                {{ $data['order']['countRefundDetail'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Doanh Số</div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Tổng Doanh Số</span>
                                                        <strong
                                                            class="text-success">{{ number_format($data['totalRevenue']) }}đ</strong>
                                                    </div>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $data['percentPriceSuccess'] }}%"
                                                            aria-valuenow="{{ $data['percentPriceSuccess'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">Đạt
                                                            {{ $data['percentPriceSuccess'] }}%</div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <small class="text-muted">Đơn Thành Công</small>
                                                                <div class="text-success">
                                                                    {{ number_format($data['successFullRevenue']) }}₫</div>
                                                            </div>
                                                            <div class="col-4">
                                                                <small class="text-muted">Đơn Hủy</small>
                                                                <div class="text-danger">
                                                                    {{ number_format($data['cancelledRevenue']) }}₫</div>
                                                            </div>
                                                            <div class="col-4">
                                                                <small class="text-muted">Đơn Hoàn</small>
                                                                <div class="text-dark">
                                                                    {{ number_format($data['refundRevenue']) }}₫</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Chi Tiết Đơn Hàng</div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Loại Đơn</th>
                                                                <th>Số Lượng</th>
                                                                <th>Doanh Số</th>
                                                                <th>Tỷ Lệ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data['orderDetails'] as $orderDetail)
                                                                <tr>
                                                                    <td>{{ $orderDetail['type'] }}</td>
                                                                    <td>{{ $orderDetail['quantity'] }}</td>
                                                                    <td>{{ number_format($orderDetail['revenue']) }}₫</td>
                                                                    <td><span
                                                                            class="badge {{ $orderDetail['badge_class'] }}">{{ $orderDetail['percentCount'] }}%</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Phương Thức Thanh Toán</div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Phương Thức</th>
                                                                <th>Số Lượng</th>
                                                                <th>Doanh Số</th>
                                                                <th>Tỷ Lệ(số lượng)</th>
                                                                <th>Tỷ Lệ(doanh số )</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data['paymentMethodData'] as $pay)
                                                                <tr>
                                                                    <td>{{ $pay['name'] }} </td>
                                                                    <td>{{ $pay['quantity'] }}</td>
                                                                    <td>{{ number_format($pay['revenue']) }}₫</td>
                                                                    <td><span
                                                                            class="badge bg-primary">{{ $pay['percentCount'] }}%</span>
                                                                    </td>
                                                                    <td><span
                                                                            class="badge bg-info">{{ $pay['percentPrice'] }}%</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- table --}}
                    <div class="row">
                        <!-- Đơn hàng -->
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h5 class="card-title mb-0">Đơn hàng ({{ $data['countUserOrders'] }})</h5>
                                    <div class="dropdown">

                                        <form
                                            action="{{ route('admin.users.customer.detail', $data['user']->id) }}"method="GET"
                                            id="filterStatus">
                                            <div class="input-group custom-dt-picker">
                                                <select name="status" id="status" class="form-control form-date"
                                                    onchange="document.getElementById('filterStatus').submit();">
                                                    <option value="0" class="form-control form-date">Tất Cả</option>

                                                    @foreach ($data['orderStatuses'] as $status)
                                                        <option value="{{ $status->name }}"
                                                            class="form-control form-date"
                                                            {{ request('status') == $status->name ? 'selected' : '' }}>
                                                            {{ $status->name }}</option>
                                                    @endforeach
                                                    <option value="refunded" class="form-control form-date"
                                                        {{ request('status') == 'refunded' ? 'selected' : '' }}>
                                                        Hoàn hàng</option>

                                                </select>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table">
                                        <tr>
                                            <th scope="col">MÃ VẬN ĐƠN</th>
                                            <th scope="col">TỔNG TIỀN</th>
                                            <th scope="col">TRẠNG THÁI ĐƠN HÀNG</th>
                                            <th scope="col">PHƯƠNG THỨC THANH TOÁN</th>
                                            <th scope="col">NGÀY ĐẶT</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data['listUserOrders']->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Không có đơn hàng nào
                                                    thỏa mãn điều kiện lọc.</td>
                                            </tr>
                                        @endif
                                        @foreach ($data['listUserOrders'] as $item)
                                            <tr>
                                                <td>
                                                    <a href="#"
                                                        class="text-decoration-none fw-bold text-primary">{{ $item['code'] }}</a>
                                                </td>
                                                <td class="fw-bold text-success">
                                                    {{ number_format($item['total_amount']) }}₫</td>
                                                <td>
                                                    <span
                                                        class="badge bg-success">{{ $item['orderStatuses'][0]['name'] }}</span>
                                                </td>
                                                <td class="text-muted">{{ $item['payment']['name'] }}</td>
                                                <td>{{ $item['created_at'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <!-- START PAGINATION -->
                            <div class="custom-pagination">
                                {{ $data['listUserOrders']->links('pagination::bootstrap-5', ['pageName' => 'list_order']) }}
                            </div>
                            <!-- END PAGINATIOn -->
                        </div>

                    </div>

                    <!-- Danh sách yêu thích -->
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="section-heading">
                                <h5 class="card-title mb-0">Danh sách yêu thích ({{ $data['countWishLists'] }})</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="wishlistDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="wishlistDropdown">
                                        <li><a class="dropdown-item" href="#">Xuất danh sách</a></li>
                                        <li><a class="dropdown-item" href="#">Gửi khuyến mãi</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table">
                                        <tr>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['wishlists'] as $wishlist)
                                            <tr>
                                                <td>
                                                    <img src="{{ Storage::url($wishlist['product']['thumbnail']) }}"
                                                        alt="Sản phẩm" class="img-thumbnail"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                </td>
                                                <td class="fw-bold">{{ $wishlist['product']['name'] }}</td>
                                                <td>
                                                    <h5 class="price mb-0">
                                                        @php $product = $wishlist['product']; @endphp
                                                        @if ($product->price != 0)
                                                            @if ($product->is_sale == 1 && $product->sale_price > 0)
                                                                <span class="theme-color fw-bold">
                                                                    {{ number_format($product->sale_price, 0, ',', '.') }}
                                                                    đ
                                                                </span>
                                                                <del class="text-muted small ms-2">
                                                                    {{ number_format($product->price, 0, ',', '.') }} đ
                                                                </del>
                                                            @else
                                                                <span class="text-success fw-bold">
                                                                    {{ number_format($product->price, 0, ',', '.') }} đ
                                                                </span>
                                                            @endif
                                                        @else
                                                            @php
                                                                $activeVariants = $product->productVariants->where(
                                                                    'is_active',
                                                                    1,
                                                                );
                                                            @endphp
                                                            @if ($activeVariants->isEmpty())
                                                                <span class="text-warning fw-bold">Liên hệ</span>
                                                            @else
                                                                @if ($product->is_sale == 1 && $product->sale_price > 0)
                                                                    <span class="badge bg-danger">Giảm giá</span>
                                                                @endif
                                                                @php
                                                                    $prices = $activeVariants
                                                                        ->pluck('price')
                                                                        ->filter()
                                                                        ->sort();
                                                                    $priceRange = $prices->isNotEmpty()
                                                                        ? number_format($prices->first(), 0, ',', '.') .
                                                                            ' - ' .
                                                                            number_format(
                                                                                $prices->last(),
                                                                                0,
                                                                                ',',
                                                                                '.',
                                                                            ) .
                                                                            ' đ'
                                                                        : 'Liên hệ';
                                                                @endphp
                                                                <span
                                                                    class="theme-color fw-bold">{{ $priceRange }}</span>
                                                            @endif
                                                        @endif
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- START PAGINATION -->
                            <div class="custom-pagination">
                                {{ $data['wishlists']->links() }}
                            </div>
                            <!-- END PAGINATIOn -->

                        </div>
                    </div>

                    <!-- Ratings & Reviews -->
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="section-heading">
                                <h5 class="card-title mb-0">Ratings &amp; reviews <span
                                        class="text-body-tertiary fw-normal">(43)</span></h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="reviewDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="reviewDropdown">
                                        <li><a class="dropdown-item" href="#">Ẩn/Hiện đánh giá hàng loạt</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Xuất danh sách đánh giá</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Lọc theo trạng thái</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">
                                                Ảnh
                                            </th>
                                            <th scope="col">
                                                Tên sản phẩm
                                            </th>
                                            <th scope="col">
                                                Đánh giá
                                            </th>
                                            <th scope="col">
                                                Nội dung
                                            </th>
                                            <th scope="col">
                                                Số lần đánh giá
                                            </th>
                                            <th scope="col">
                                                Thao tác
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['reviews'] as $review)
                                            <tr>
                                                <td>
                                                    <img src="{{ Storage::url($review['thumbnail']) }}" alt="Sản phẩm 1"
                                                        class="img-thumbnail"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                </td>
                                                <td class="fw-bold">{{ $review['name'] }}</td>
                                                <td class="">
                                                    <ul class="d-flex justify-content-center rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <li>
                                                                <i data-feather="star"
                                                                    class="{{ $i <= round($review['reviews'][0]['rating']) ? 'fill text-warning' : '' }}"></i>
                                                            </li>
                                                        @endfor
                                                    </ul>

                                                    {{-- <i class="fas fa-star text-warning"></i> --}}
                                                </td>
                                                <td>{{ $review['reviews'][0]['review_text'] }}</td>
                                                <td>{{ $review['reviews_count'] }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info view-details-btn"
                                                        data-bs-toggle="modal" data-bs-target="#reviewsModal"
                                                        data-product-id="{{ $review['id'] }}"
                                                        data-product-name="{{ $review['name'] }}"> <i
                                                            class="ri-eye-line"></i> Xem chi tiết
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                            </div>

                            <!-- START PAGINATION -->
                            <div class="custom-pagination">
                                {{ $data['reviews']->links('pagination::bootstrap-5', ['pageName' => 'reviews_page']) }}
                            </div>
                            <!-- END PAGINATIOn -->
                        </div>
                    </div>


                </div>


                <div class="row">

                    <div class="col-lg-6">

                    </div>

                    <div class="col-lg-6">

                    </div>

                </div>




    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- Modal Rank -->
    <div class="modal fade" id="viewRank" tabindex="-1" aria-labelledby="viewRankLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <!-- Modal Header with Gradient -->
                <div class="modal-header border-0 position-relative"
                    style="background: #0da487; min-height: 100px; border-radius: 0.5rem 0.5rem 0 0;">
                    <div class="position-absolute w-100 text-center" style="top: 50%; transform: translateY(-50%);">
                        <h4 class="modal-title text-white mb-0 fw-bold" id="viewRankLabel">
                            <i class="fas fa-crown me-2" style="color: #FFD700;"></i>
                            Xếp Hạng Thành Viên
                        </h4>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <!-- Current Rank Banner -->
                    <div class="text-center mb-4">
                        <div class="badge bg-gradient px-4 py-2 fs-6" style="background: #0da487">
                            Cấp Độ Hiện Tại
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row g-4 justify-content-center">
                        <!-- Rank Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-3"
                                    style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                                    <div class="rank-icon mb-3">
                                        <i class="fas fa-medal fa-3x" style="color: #FFD700;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Cấp Bậc</h5>
                                    <h3 class="text-warning fw-bold mb-0 display-6">
                                        {{ ucfirst($data['userRank']) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-warning">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Points Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-3"
                                    style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <div class="points-icon mb-3">
                                        <i class="fas fa-gem fa-3x" style="color: #E0F7FA;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Điểm Loyalty</h5>
                                    <h3 class="text-white fw-bold mb-0 display-6">
                                        {{ number_format($data['user']->loyalty_points) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-info">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-3"
                                    style="background: linear-gradient(135deg, #eb3349, #f45c43);">
                                    <div class="orders-icon mb-3">
                                        <i class="fas fa-shopping-bag fa-3x" style="color: #FFF;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Tổng Đơn Hàng</h5>
                                    <h3 class="text-white fw-bold mb-0 display-6">
                                        {{ number_format($data['countOrder']['allCount']) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-danger">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    {{-- <div class="mt-5">
                            <h6 class="text-center mb-4 fw-bold text-muted">
                                <i class="fas fa-chart-bar me-2"></i>Tiến Độ Lên Hạng
                            </h6>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100">
                                    75%
                                </div>
                            </div>
                        </div> --}}
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-danger btn-lg px-4 fw-bold" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal review --}}

    <div class="modal fade theme-modal question-modal" id="reviewsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reviewsModalLabel">Chi tiết đánh giá cho <span
                            id="modal-product-name">Tên sản phẩm mẫu</span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div id="modal-reviews-content">
                        <div class="review-people">
                            <ul class="review-list">
                                <li>
                                    <div class="people-box">
                                        <div>
                                            <div class="people-image people-text">
                                                <h3 class="text-center rounded-circle bg-white d-inline-flex align-items-center justify-content-center"
                                                    style="width: 70px; height: 70px;">
                                                    NM
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="people-comment">
                                            <div class="people-name"><a href="javascript:void(0)" class="name">Nguyen
                                                    Manh</a>
                                                <div class="date-time">
                                                    <h6 class="text-content">
                                                        01/04/2025 14:14:31
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">

                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill "></i>
                                                    <i data-feather="star" class="fill "></i>


                                                </ul>
                                            </div>
                                            <div class="reply">
                                                <p>giá cả áo ma thế ???</p>
                                            </div>
                                            <div class="review-images mt-2">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 1"
                                                    class="img-thumbnail me-1">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 2"
                                                    class="img-thumbnail me-1">

                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="people-box">
                                        <div>
                                            <div class="people-image people-text">
                                                <h3 class="text-center rounded-circle bg-white d-inline-flex align-items-center justify-content-center"
                                                    style="width: 70px; height: 70px;">
                                                    NM
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="people-comment">
                                            <div class="people-name"><a href="javascript:void(0)" class="name">Nguyen
                                                    Manh</a>
                                                <div class="date-time">
                                                    <h6 class="text-content">
                                                        01/04/2025 15:41:15
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill text-warning"></i>
                                                    <i data-feather="star" class="fill "></i>
                                                    <i data-feather="star" class="fill "></i>
                                                </ul>
                                            </div>
                                            <div class="reply">
                                                <p>Đánh giá sản phẩm mang tính chất nhận xu</p>
                                            </div>
                                            <div class="review-images mt-2">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 1"
                                                    class="img-thumbnail me-1">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 2"
                                                    class="img-thumbnail me-1">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 3"
                                                    class="img-thumbnail me-1">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 4"
                                                    class="img-thumbnail me-1">
                                                <img src="https://picsum.photos/200/300" alt="Ảnh đánh giá 5"
                                                    class="img-thumbnail">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-theme-outline fw-bold"
                        data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@endsection






{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script>
        var customerId = {{ $data['user']['id'] }}; // Giả sử bạn có biến $customer chứa thông tin khách hàng

        $('.view-details-btn').on('click', function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');

            $.ajax({
                url: '/user/products/' + productId + '/reviews?userId=' + customerId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('AJAX request successful');
                    console.log(data); // Bạn có thể log data để xem trong console
                },
                error: function(error) {
                    console.error('Lỗi AJAX:', error);
                }
            });
        });
        //   
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
