<template>
    <div class="editor relative">
        <editor-menu-bubble :editor="editor" :keep-in-bounds="keepInBounds" v-slot="{ commands, isActive, menu }">
            <div
                class="menububble"
                :class="{ 'is-active': menu.isActive }"
                :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
            >

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.bold() }"
                    @click.prevent="commands.bold"
                >
                    <icon name="bin"/>
                </button>

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.italic() }"
                    @click.prevent="commands.italic"
                >
                    <icon name="edit"/>
                </button>

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.blockquote() }"
                    @click.prevent="commands.blockquote"
                >
                    <icon name="bin"/>
                </button>

            </div>
        </editor-menu-bubble>
        <div class="h-60 overflow-y-auto">
            <editor-content class="editor__content" :class="getClasses" :editor="editor"/>
        </div>
    </div>
</template>

<script>
import Icon from '@/Components/Icon'
import {Editor, EditorContent, EditorMenuBubble} from 'tiptap'
import {
    Blockquote,
    Bold,
    BulletList,
    CodeBlock,
    HardBreak,
    Heading,
    History,
    Italic,
    Link,
    ListItem,
    OrderedList,
    Strike,
    TodoItem,
    TodoList,
    Underline,
} from 'tiptap-extensions'

export default {
    components: {
        EditorContent,
        EditorMenuBubble,
        Icon,
    },
    props: {
        init: "",
        height: {
            default: "md",
        }
    },
    data() {
        return {
            keepInBounds: true,
            editor: new Editor({
                extensions: [
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new HardBreak(),
                    new Heading({levels: [1, 2, 3]}),
                    new ListItem(),
                    new OrderedList(),
                    new TodoItem(),
                    new TodoList(),
                    new Link(),
                    new Bold(),
                    new Italic(),
                    new Strike(),
                    new Underline(),
                    new History(),
                ],
                content: this.init,
                onUpdate: ({getHTML}) => {
                    const content = getHTML()
                    this.$emit('input', content)
                }
            }),
        }
    },
    beforeDestroy() {
        this.editor.destroy()
    },
    mounted() {
        console.log({
            sm: 'h-12',
            md: 'h-24',
            lg: 'h-48'
        }[this.height])
    },
    computed: {
        getClasses() {
            return [{
                sm: 'h-12',
                md: 'h-24',
                lg: 'h-48'
            }[this.height]]
        },
    }
}
</script>
