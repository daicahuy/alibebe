@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                                    <img src="https://picsum.photos/id/237/100/100" alt="Ảnh đại diện khách hàng"
                                        class="customer-avatar mb-2">
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
                                            <div class="stat-label">Đơn hàng</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">56</div>
                                            <div class="stat-label">Thành công</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-box">
                                            <div class="stat-number text-primary">97</div>
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
                                    {{-- <p class="mb-0">Phú Thọ</p>
                                    <p class="mb-0">Hoàng Cương, Thanh Ba</p>
                                    <p class="mb-0">Khu 2</p> --}}
                                    <p>{{ $defaultAddresses->address }}</p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 fw-bold">Email</p>
                                    <p class="mb-0"><a href="mailto:shatinon@jaemail.com"
                                            class="text-decoration-none">shatinon@jaemail.com</a></p>
                                </div>

                                <div>
                                    <p class="mb-1 fw-bold">Điện thoại</p>
                                    <p class="mb-0">{{ $defaultAddresses->phone_number }}</p>
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
                                                Đặt đơn hàng #2453
                                            </div>
                                            <small class="text-muted">Hôm nay</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                Thêm sản phẩm yêu thích
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
                            {{-- </div> --}}
                            {{-- <div class="card mb-6"> --}}
                            <br>
                            <div class="card-body">
                                <div class="section-heading">
                                    <h6 class="card-subtitle mb-0">Phân loại khách hàng</h6>

                                </div>
                                <div class="d-flex flex-wrap">
                                    <span class="badge bg-primary me-2 mb-2">Khách VIP</span>
                                    {{-- <span class="badge bg-info me-2 mb-2">Đam mê công nghệ</span>
                                <span class="badge bg-success me-2 mb-2">Mua sắm thường xuyên</span> --}}
                                </div>
                            </div>
                            {{-- </div> --}}
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
                                        <form method="GET" action="{{ route('admin.reviews.index') }}"
                                            class="d-flex justify-content-evenly align-items-end flex-wrap gap-3 w-100">
                                            <!-- Start Date -->
                                            <div class="flex-grow-1">
                                                <label for="startDate" class="form-label fw-bold mb-0">Ngày bắt
                                                    đầu</label>
                                                <input type="date" id="startDate" name="startDate"
                                                    value="{{ request('startDate') }}" class="form-control">
                                            </div>

                                            <!-- End Date -->
                                            <div class="flex-grow-1">
                                                <label for="endDate" class="form-label fw-bold mb-0">Ngày kết
                                                    thúc</label>
                                                <input type="date" id="endDate" name="endDate"
                                                    value="{{ request('endDate') }}" class="form-control">
                                            </div>

                                            <!-- Filter & Reset Buttons -->
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-theme">Lọc</button>
                                                <a href="{{ route('admin.reviews.index') }}"
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
                                                        <strong class="text-primary">97</strong>
                                                    </div>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar progress-bar-custom" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100">Hoàn Thành 50%</div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-muted">Chi Tiết Trạng Thái</small>
                                                        <div class="d-flex justify-content-between mt-1">
                                                            <span class="badge bg-success badge-custom">Thành Công:
                                                                48</span>
                                                            <span class="badge bg-warning badge-custom">Đang Xử Lý:
                                                                15</span>
                                                            <span class="badge bg-danger badge-custom">Hủy: 34</span>
                                                            <span class="badge bg-dark badge-custom">Hoàn hàng: 3</span>
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
                                                        <strong class="text-success">132.540.000₫</strong>
                                                    </div>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                            aria-valuemax="100">Đạt 75%</div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted">Đơn Thành Công</small>
                                                                <div class="text-success">96.490.000₫</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Đơn Hủy</small>
                                                                <div class="text-danger">29.320.000₫</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="card mb-3">
                                                <div class="card-header">Hiệu Suất</div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6 text-center">
                                                            <div class="fs-4 text-primary">4.8/5</div>
                                                            <small class="text-muted">Đánh Giá</small>
                                                        </div>
                                                        <div class="col-6 text-center">
                                                            <div class="fs-4 text-success">98%</div>
                                                            <small class="text-muted">Độ Hài Lòng</small>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="text-center">
                                                        <span class="badge bg-warning me-1">Cần Cải Thiện</span>
                                                        <span class="badge bg-info">Tiềm Năng Cao</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
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
                                                            <tr>
                                                                <td>Đã Hoàn Thành</td>
                                                                <td>48</td>
                                                                <td>96.490.000₫</td>
                                                                <td><span class="badge bg-success">72.5%</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Đã Hủy</td>
                                                                <td>34</td>
                                                                <td>29.320.000₫</td>
                                                                <td><span class="badge bg-danger">22.1%</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Đang Xử Lý</td>
                                                                <td>15</td>
                                                                <td>3.750.000₫</td>
                                                                <td><span class="badge bg-warning">5.4%</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hoàn hàng</td>
                                                                <td>5</td>
                                                                <td>3.750.000₫</td>
                                                                <td><span class="badge bg-dark">3.4%</span></td>
                                                            </tr>
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
                                                                <th>Tỷ Lệ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Khi nhận hàng </td>
                                                                <td>23</td>
                                                                <td>46.320.000₫</td>
                                                                <td><span class="badge bg-primary">35%</span></td>
                                                            </tr>
                                                            {{-- <tr>
                                                                <td>Chuyển Khoản</td>
                                                                <td>35</td>
                                                                <td>62.540.000₫</td>
                                                                <td><span class="badge bg-success">47%</span></td>
                                                            </tr> --}}
                                                            <tr>
                                                                <td>Online</td>
                                                                <td>24</td>
                                                                <td>23.680.000₫</td>
                                                                <td><span class="badge bg-info">18%</span></td>
                                                            </tr>
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

                    <div class="row">
                        <!-- Đơn hàng -->
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h5 class="card-title mb-0">Đơn hàng (97)</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            id="ordersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-filter me-1"></i> Lọc
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="ordersDropdown">
                                            <li><a class="dropdown-item" href="#">Tất cả đơn hàng</a></li>
                                            <li><a class="dropdown-item" href="#">Đơn hàng đã hoàn thành</a>
                                            </li>
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
                                                    MÃ VẬN ĐƠN
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                <th scope="col">
                                                    TỔNG TIỀN
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                <th scope="col">
                                                    TRẠNG THÁI THANH TOÁN
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                <th scope="col">
                                                    TRẠNG THÁI ĐƠN HÀNG
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                <th scope="col">
                                                    PHƯƠNG THỨC THANH TOÁN
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                <th scope="col">
                                                    NGÀY ĐẶT
                                                    {{-- <i class="fas fa-sort-down ms-1"></i> --}}
                                                </th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2453</a></td>
                                                <td>87.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge fulfilled">ĐÃ HOÀN THÀNH</span>
                                                </td>
                                                <td>Tiền mặt khi nhận hàng</td>
                                                <td>12/12, 12:56</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2452</a></td>
                                                <td>2.784.000₫</td>
                                                <td><span class="badge status-badge cancelled">ĐÃ HỦY</span></td>
                                                <td><span class="badge status-badge ready">SẴN SÀNG LẤY HÀNG</span>
                                                </td>
                                                <td>Miễn phí vận chuyển</td>
                                                <td>09/12, 14:28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2451</a></td>
                                                <td>375.000₫</td>
                                                <td><span class="badge status-badge pending">ĐANG XỬ LÝ</span></td>
                                                <td><span class="badge status-badge partial">HOÀN THÀNH MỘT PHẦN</span>
                                                </td>
                                                <td>Nhận tại cửa hàng</td>
                                                <td>04/12, 12:56</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2450</a></td>
                                                <td>557.000₫</td>
                                                <td><span class="badge status-badge cancelled">ĐÃ HỦY</span></td>
                                                <td><span class="badge status-badge cancelled">ĐƠN HÀNG ĐÃ HỦY</span>
                                                </td>
                                                <td>Vận chuyển tiêu chuẩn</td>
                                                <td>01/12, 04:07</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2449</a></td>
                                                <td>9.562.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge fulfilled">ĐÃ HOÀN THÀNH</span>
                                                </td>
                                                <td>Chuyển phát nhanh</td>
                                                <td>28/11, 19:28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2448</a></td>
                                                <td>46.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge delivery-delayed">GIAO HÀNG
                                                        CHẬM</span>
                                                </td>
                                                <td>Giao hàng tận nơi</td>
                                                <td>24/11, 10:16</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="text-decoration-none">#2448</a></td>
                                                <td>46.000₫</td>
                                                <td><span class="badge status-badge paid">ĐÃ THANH TOÁN</span></td>
                                                <td><span class="badge status-badge delivery-delayed">GIAO HÀNG
                                                        CHẬM</span>
                                                </td>
                                                <td>Giao hàng tận nơi</td>
                                                <td>24/11, 10:16</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Xem chi
                                                                    tiết</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">In hóa đơn</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Theo dõi đơn
                                                                    hàng</a></li>
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
                                        <a href="#" class="view-all">Xem tất cả <i
                                                class="fas fa-chevron-right ms-1"></i></a>
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

                        <!-- Danh sách yêu thích -->
                        <div class="card mb-12">
                            <div class="card-body">
                                <div class="section-heading">
                                    <h5 class="card-title mb-0">Danh sách yêu thích (43)</h5>
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
                                    <table class="table align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    Ảnh
                                                </th>
                                                <th scope="col">
                                                    Tên
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                {{-- <th scope="col">
                                MÀU SẮC
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th scope="col">
                                KÍCH THƯỚC
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th> --}}
                                                <th scope="col">
                                                    GIÁ
                                                    {{-- <i class="fas fa-sort ms-1 text-muted"></i> --}}
                                                </th>
                                                {{-- <th scope="col">
                                TỔNG
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><img src="https://picsum.photos/id/237/100/100" alt="Sản phẩm"
                                                        class="img-thumbnail" width="40"></td>
                                                <td class="product-title">Đồng hồ thông minh Fitbit Sense Advanced
                                                </td>
                                                {{-- <td>Đen mờ</td>
                            <td>42</td>
                            <td>1.150.000₫</td> --}}
                                                <td>1.150.000₫</td>
                                            </tr>
                                            <tr>
                                                <td><img src="https://picsum.photos/id/237/100/100" alt="Sản phẩm"
                                                        class="img-thumbnail" width="40"></td>
                                                <td class="product-title">iPad Pro 12.9-inch 2023 Wi-Fi + Cellular
                                                </td>
                                                {{-- <td>Đen</td>
                            <td>Pro</td>
                            <td>29.990.000₫</td> --}}
                                                <td>29.990.000₫</td>
                                            </tr>
                                            <tr>
                                                <td><img src="https://picsum.photos/id/237/100/100" alt="Sản phẩm"
                                                        class="img-thumbnail" width="40"></td>
                                                <td class="product-title">Tay cầm không dây PlayStation 5 DualSense
                                                </td>
                                                {{-- <td>Trắng</td>
                            <td>Tiêu chuẩn</td>
                            <td>1.790.000₫</td> --}}
                                                <td>1.790.000₫</td>
                                            </tr>
                                            <tr>
                                                <td><img src="https://picsum.photos/id/237/100/100" alt="Sản phẩm"
                                                        class="img-thumbnail" width="40"></td>
                                                <td class="product-title">MacBook Pro 13 inch M1 8C256G</td>
                                                {{-- <td>Xám không gian</td>
                            <td>Pro</td>
                            <td>29.990.000₫</td> --}}
                                                <td>29.990.000₫</td>
                                            </tr>
                                            <tr>
                                                <td><img src="https://picsum.photos/id/237/100/100" alt="Sản phẩm"
                                                        class="img-thumbnail" width="40"></td>
                                                <td class="product-title">Apple iMac 24" 4K Retina Display M1 8C
                                                </td>
                                                {{-- <td>Xanh dương</td>
                            <td>21"</td>
                            <td>1.790.000₫</td> --}}
                                                <td>1.790.000₫</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">1 đến 5 trên tổng số 9</div>
                                    <div>
                                        <a href="#" class="view-all">Xem tất cả <i
                                                class="fas fa-chevron-right ms-1"></i></a>
                                    </div>
                                </div>

                                <nav class="mt-3" aria-label="Phân trang danh sách yêu thích">
                                    <ul class="pagination pagination-sm justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Trước">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active" href="#">1</a>
                                        </li>
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
                                            <li><a class="dropdown-item" href="#">Xuất danh sách đánh giá</a></li>
                                            <li><a class="dropdown-item" href="#">Lọc theo trạng thái</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle">
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
                                            <tr>
                                                <td>
                                                    <img src="https://picsum.photos/id/300/50/50" alt="Sản phẩm 1"
                                                        class="img-thumbnail" width="40">
                                                </td>
                                                <td class="product-title">Tablet M25 Plus 163948</td>
                                                <td>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill "></i>

                                                    {{-- <i class="fas fa-star text-warning"></i> --}}
                                                </td>
                                                <td>Sản phẩm dùng ổn, giá hợp lý.</td>
                                                <td>15</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="#"><i class="ri-eye-line"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="https://picsum.photos/id/301/50/50" alt="Sản phẩm 2"
                                                        class="img-thumbnail" width="40">
                                                </td>
                                                <td class="product-title">Điện thoại Samsung Galaxy S23</td>
                                                <td>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill "></i>
                                                    <i data-feather="star"class="fill "></i>
                                                </td>
                                                <td>Rất tốt, nhân viên tư vấn nhiệt tình.</td>
                                                <td>28</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="#"><i class="ri-eye-line"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="https://picsum.photos/id/302/50/50" alt="Sản phẩm 3"
                                                        class="img-thumbnail" width="40">
                                                </td>
                                                <td class="product-title">Tai nghe Sony WH-1000XM5</td>
                                                <td>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill "></i>
                                                </td>
                                                <td>Âm thanh hay, nhưng hơi cấn tai khi đeo lâu.</td>
                                                <td>10</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="#"><i class="ri-eye-line"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="https://picsum.photos/id/303/50/50" alt="Sản phẩm 4"
                                                        class="img-thumbnail" width="40">
                                                </td>
                                                <td class="product-title">Máy tính bảng iPad Air 5</td>
                                                <td>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                    <i data-feather="star"class="fill text-warning"></i>
                                                </td>
                                                <td>Màn hình đẹp, pin dùng được cả ngày.</td>
                                                <td>22</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="#"><i class="ri-eye-line"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">1 đến 4 trên tổng số 43</div>
                                    <div>
                                        <a href="#" class="view-all">Xem tất cả <i
                                                class="fas fa-chevron-right ms-1"></i></a>
                                    </div>
                                </div>

                                <nav class="mt-3" aria-label="Phân trang danh sách đánh giá">
                                    <ul class="pagination pagination-sm justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Trước">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active" href="#">1</a>
                                        </li>
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

                        <div class="col-lg-6">

                        </div>

                        <div class="col-lg-6">

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
