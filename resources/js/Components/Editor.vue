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
                    <span class="bold font-mono">B</span>
                </button>

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.italic() }"
                    @click.prevent="commands.italic"
                >
                    <span class="italic font-mono">I</span>
                </button>

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.blockquote() }"
                    @click.prevent="commands.blockquote"
                >
                    <span class="font-serif">"</span>
                </button>

                <button
                    class="menububble__button"
                    :class="{ 'is-active': isActive.rtl() }"
                    @click.prevent="commands.rtl"
                >
                    <span class="font-serif">rtl</span>
                </button>

                <button
                    class="menububble__button"
                    @click="commands.undo"
                >
                    <span class="font-serif text-sm">undo</span>
                </button>

                <button
                    class="menububble__button"
                    @click="commands.redo"
                >
                    <span class="font-serif text-sm">redo</span>
                </button>

            </div>
        </editor-menu-bubble>

        <editor-content class="editor__content bg-white shadow overflow-y-auto rounded border border-gray-300 p-2 leading-relaxed"
                        :class="[getClasses, focused ? 'ring-2 ring-indigo-500 ring-opacity-25 border border-indigo-500' : '']" :editor="editor"/>

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
import RTL from '@/Components/custom/rtl'

export default {
    components: {
        EditorContent,
        EditorMenuBubble,
        Icon,
    },
    props: {
        value: "",
        height: {
            default: "",
        },
        autofocus: {
            default: false
        }
    },
    data() {
        return {
            focused: this.autofocus,
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
                    new RTL(),
                ],
                content: this.value,
                onFocus: () => {
                    this.focused = true
                },
                onBlur: () => {
                  this.focused = false
                },
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

    },
    computed: {
        getClasses() {
            return [{
                sm: 'h-12',
                md: 'h-24',
                lg: 'h-56',

            }[this.height]]
        },
    }
}
</script>
