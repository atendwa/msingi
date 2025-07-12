<section x-cloak x-show="showFlash" class="absolute gap-4" x-data="flashComponent()" :class="position()">
    <main
        class="relative z-50 w-full cursor-pointer gap-3 rounded-xl border px-3 py-3 shadow-sm"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-y-1/2 opacity-50"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="duration-300 ease-out"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-1/2 opacity-0"
        x-show="showFlash"
        x-cloak
        @keydown.escape.window="showFlash = false"
        @click.prevent="showFlash = false"
        :class="cardClasses()"
        x-init="
            () => {
                setTimeout(() => {
                    showFlash = false
                }, 20000)
            }
        "
    >
        <section class="flex-1">
            <div class="flex items-center justify-between gap-8" :class="titleClasses()">
                <h2 x-text="heading"></h2>

                <svg
                    class="size-6 hover:rotate-90 focus:rotate-90"
                    fill="currentColor"
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>

            <p x-text="message" class="mt-1 max-w-3xl text-sm leading-6 text-slate-900"></p>
        </section>

        <script>
            function flashComponent() {
                return {
                    titleClasses() {
                        return this.title[this.type];
                    },

                    cardClasses() {
                        let base = this.card[this.type];

                        if (this.showRecordPaymentModal) {
                            return base + ' col-start-1 ';
                        }

                        return base + ' col-start-2 ';
                    },

                    position() {
                        let base = ' left-1/2 -translate-x-1/2 z-20 ';

                        if (this.showCancelSaleModal || this.showItemsModal || this.showMpesaTransactionsModal) {
                            return base + ' bottom-6 ';
                        }

                        base = ' right-4 grid grid-cols-2';

                        if (this.showRecordPaymentModal) {
                            return ' bottom-6 left-6' + base;
                        }

                        return ' left-4 bottom-4 ' + base;
                    },

                    title: {
                        success: 'text-green-900',
                        info: 'text-blue-900',
                        error: 'text-red-900'
                    },

                    card: {
                        success: 'border-green-500 bg-green-200',
                        info: 'border-blue-500 bg-blue-200',
                        error: 'border-red-500 bg-red-100'
                    }
                };
            }
        </script>
    </main>
</section>
