<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>

export default {
    props: [ 'card' ],
    data() {
        return {
            contentElement: null,
            cardsElement: null,

        };
    },

    mounted() {
        if( this.selfElement ) {
            this.cardsElement = this.selfElement.parentElement;
            this.contentElement = this.cardsElement.parentElement.parentElement;
            this.removeMe();
        }

        Nova.$on( 'resources-loaded', function () {
            setTimeout( this.applyFor, 100 );
        }.bind( this ) );
    },

    methods: {
        applyFor() {
            if( !this.shouldApply() ) {
                return;
            }

            if( this.forValue || (
                !this.forValue && this.showWhenEmpty
            ) ) {
                if( this.for && this.for.trim() === 'HeadTitle' ) {
                    this.valueType === 'appendable' && this.appendMainComponentLabel( this.forValue );
                    this.valueType === 'suffixable' && this.suffixMainComponentLabel( this.forValue );
                    this.valueType === 'replaceable' && this.setMainComponentLabel( this.forValue );
                }
            }
        },
        shouldApply() {
            return this.$attrs.resourceName === this.$route.params.resourceName &&
                   this.$route.name === 'index';
        },
        removeMe() {
            if( this.selfElement && this.removeElement ) {
                this.selfElement.remove();
            }
            if( this.cardsElement && this.removeParentElementWhenEmpty && !this.cardsElement.children.length ) {
                this.cardsElement.remove();
            }
        },
        appendMainComponentLabel(label) {
            this.resetMainComponentLabel();
            if( this.titleElement && this.contentElementByRef ) {
                this.titleElement.append( " " );
                this.titleElement.append( this.contentElementByRef );
            } else {
                this.setMainComponentLabel( this.mainComponentResponseLabel + label );
            }
        }
        ,
        suffixMainComponentLabel(label) {
            if( this.titleElement && this.contentElementByRef ) {
                this.titleElement.prepend( " " );
                this.titleElement.prepend( this.contentElementByRef );
            } else {
                this.setMainComponentLabel( label + this.mainComponentResponseLabel );
            }
        },
        setMainComponentLabel(label) {
            if( this.titleElement && this.contentElementByRef ) {
                this.titleElement.innerHTML = label;
                this.titleElement.append( this.contentElementByRef );
            } else {
                if( this.mainComponentResponse ) {
                    this.mainComponentResponse.label = label;
                }
            }
        },
        resetMainComponentLabel() {
            this.setMainComponentLabel( this.mainComponentResponseLabel );
        },
    }
    ,

    computed: {
        mainComponent() {
            return this.$route.matched[ 0 ].instances.default;
        },
        titleElement() {
            let elements = this.mainComponent.$el.querySelectorAll( 'h1' );
            return elements[ elements.length - 1 ];
        },
        contentElementByRef() {
            return this.$refs.content_element && this.$refs.content_element.$el || null;
        },
        mainComponentResponse() {
            return this.mainComponent.resourceResponse;
        }
        ,
        mainComponentResponseLabel() {
            return this.mainComponentResponse && this.mainComponentResponse.label;
        }
        ,
        selfElement() {
            return this.$el.parentElement;
        }
        ,
        cardsElement() {
            return this.selfElement.parentElement;
        }
        ,
        removeElement() {
            return this.card.removeElement;
        }
        ,
        removeParentElementWhenEmpty() {
            return this.card.removeParentElementWhenEmpty;
        }
        ,
        showWhenEmpty() {
            return this.card.showWhenEmpty || false;
        },
        for() {
            return this.card.for || "";
        }
        ,
        forValue() {
            return (
                this.card.for_value || ""
            ).replaceAll( "\n", "<br>" );
        }
        ,
        valueType() {
            return this.card.valueType || "appendable";
        }
        ,
    },
}
</script>
