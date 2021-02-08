import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
} from 'vue-tailwind/dist/components';

export default {
    't-rich-select': {
        component: TRichSelect,
        props: {
            fixedClasses: {
                wrapper: 'relative',
                buttonWrapper: 'inline-block relative w-full',
                selectButton: 'w-full flex text-left justify-between items-center px-3 py-2 text-black transition duration-100 ease-in-out border rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed',
                selectButtonLabel: 'block truncate',
                selectButtonPlaceholder: 'block truncate',
                selectButtonIcon: 'fill-current flex-shrink-0 ml-1 h-4 w-4',
                selectButtonClearButton: 'rounded flex flex-shrink-0 items-center justify-center absolute right-0 top-0 m-2 h-6 w-6 transition duration-100 ease-in-out',
                selectButtonClearIcon: 'fill-current h-3 w-3',
                dropdown: 'absolute w-full z-10 -mt-1 absolute border-b border-l border-r rounded-b shadow-sm z-10',
                dropdownFeedback: '',
                loadingMoreResults: '',
                optionsList: 'overflow-auto',
                searchWrapper: 'inline-block w-full',
                searchBox: 'inline-block w-full',
                optgroup: '',
                option: 'cursor-pointer',
                disabledOption: 'opacity-50 cursor-not-allowed',
                highlightedOption: 'cursor-pointer',
                selectedOption: 'cursor-pointer',
                selectedHighlightedOption: 'cursor-pointer',
                optionContent: '',
                optionLabel: 'truncate block',
                selectedIcon: 'fill-current h-4 w-4',
                enterClass: '',
                enterActiveClass: '',
                enterToClass: '',
                leaveClass: '',
                leaveActiveClass: '',
                leaveToClass: ''
            },
            classes: {
                wrapper: '',
                buttonWrapper: '',
                selectButton: 'bg-white border-gray-300',
                selectButtonLabel: '',
                selectButtonPlaceholder: 'text-gray-400',
                selectButtonIcon: 'text-gray-600',
                selectButtonClearButton: 'hover:bg-blue-100 text-gray-600',
                selectButtonClearIcon: '',
                dropdown: 'bg-white border-gray-300',
                dropdownFeedback: 'pb-2 px-3 text-gray-400 text-sm',
                loadingMoreResults: 'pb-2 px-3 text-gray-400 text-sm',
                optionsList: '',
                searchWrapper: 'p-2 placeholder-gray-400',
                searchBox: 'px-3 py-2 bg-gray-50 text-sm rounded border focus:outline-none focus:shadow-outline border-gray-300',
                optgroup: 'text-gray-400 uppercase text-xs py-1 px-2 font-semibold',
                option: '',
                disabledOption: '',
                highlightedOption: 'bg-blue-100',
                selectedOption: 'font-semibold bg-gray-100 bg-blue-500 font-semibold text-white',
                selectedHighlightedOption: 'font-semibold bg-gray-100 bg-blue-600 font-semibold text-white',
                optionContent: 'flex justify-between items-center px-3 py-2',
                optionLabel: '',
                selectedIcon: '',
                enterClass: '',
                enterActiveClass: 'opacity-0 transition ease-out duration-100',
                enterToClass: 'opacity-100',
                leaveClass: 'transition ease-in opacity-100',
                leaveActiveClass: '',
                leaveToClass: 'opacity-0 duration-75'
            },
            variants: {
                danger: {
                    selectButton: 'border-red-300 bg-red-50 text-red-900',
                    selectButtonPlaceholder: 'text-red-200',
                    selectButtonIcon: 'text-red-500',
                    selectButtonClearButton: 'hover:bg-red-200 text-red-500',
                    dropdown: 'bg-red-50 border-red-300'
                },
                success: {
                    selectButton: 'border-green-300 bg-green-50 text-green-900',
                    selectButtonIcon: 'text-green-500',
                    selectButtonClearButton: 'hover:bg-green-200 text-green-500',
                    dropdown: 'bg-green-50 border-green-300'
                }
            }
        }
    },
    't-select': {
        component: TSelect,
        props: {
            fixedClasses: 'block w-full pl-3 pr-10 py-2 transition duration-100 ease-in-out border rounded shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed',
            classes: 'text-black placeholder-gray-400 bg-white border-gray-300 focus:border-blue-500 ',
            variants: {
                danger: 'border-red-300 bg-red-50 placeholder-red-200 text-red-900',
                success: 'border-green-300 bg-green-50 placeholder-gray-400 text-green-900'
            }
        }
    },
    't-table': {
      component: TTable,
    },
    't-button': {
        component: TButton,
    },
    't-modal': {
        component: TModal,
        props: {
            fixedClasses: {
                overlay: 'z-40  overflow-auto scrolling-touch left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50',
                wrapper: 'relative mx-auto z-50 max-w-lg px-3 py-12',
                modal: 'overflow-visible relative  rounded',
                body: 'p-3',
                header: 'border-b p-3 rounded-t',
                footer: ' p-3 rounded-b',
                close: 'flex items-center justify-center rounded-full absolute right-0 top-0 -m-3 h-8 w-8 transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50'
            },
            classes: {
                overlay: 'bg-black',
                wrapper: 'max-w-3xl',
                modal: 'bg-white shadow',
                body: 'p-3',
                header: 'border-gray-100',
                footer: 'bg-gray-100',
                close: 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                closeIcon: 'fill-current h-4 w-4',
                overlayEnterClass: '',
                overlayEnterActiveClass: 'opacity-0 transition ease-out duration-100',
                overlayEnterToClass: 'opacity-100',
                overlayLeaveClass: 'transition ease-in opacity-100',
                overlayLeaveActiveClass: '',
                overlayLeaveToClass: 'opacity-0 duration-75',
                enterClass: '',
                enterActiveClass: '',
                enterToClass: '',
                leaveClass: '',
                leaveActiveClass: '',
                leaveToClass: ''
            },
            variants: {
                danger: {
                    overlay: 'bg-red-100',
                    header: 'border-red-50 text-red-700',
                    close: 'bg-red-50 text-red-700 hover:bg-red-200 border-red-100 border',
                    modal: 'bg-white border border-red-100 shadow-lg',
                    footer: 'bg-red-50'
                }
            }
        }
    },

    't-toolbar-button': {
        component: TButton,
        props: {
            tagName: 'button',
        }

    },
    't-input': {
        component: TInput,
        props: {
            fixedClasses: 'block w-full px-3 py-2 transition duration-100 ease-in-out border rounded shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed',
            classes: 'text-black placeholder-gray-400 bg-white border-gray-300 focus:border-blue-500 ',
            variants: {
                danger: 'border-red-300 bg-red-50 placeholder-red-200 text-red-900',
                success: 'border-green-300 bg-green-50 placeholder-gray-400 text-green-900'
            }
        }
    },
    't-textarea': {
        component: TTextarea,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
            // ...More settings
        }
    },
    // ...Rest of the components
}

