<x-filament::widget>
    <x-filament::card class="p-0">
        <div
            x-data="{
                slides: {{ json_encode($images) }},
                index: 0,
                autoplayMs: {{ $autoplayMs }},
                intervalId: null,
                next() { this.index = (this.index + 1) % this.slides.length },
                prev() { this.index = (this.index - 1 + this.slides.length) % this.slides.length },
                start() {
                    if (this.slides.length > 1) {
                        this.stop();
                        this.intervalId = setInterval(() => this.next(), this.autoplayMs);
                    }
                },
                stop() { if (this.intervalId) { clearInterval(this.intervalId); this.intervalId = null } },
                init() { this.start() }
            }"
            @mouseenter="stop()"
            @mouseleave="start()"
            class="relative w-full overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="relative w-full" style="aspect-ratio: {{ $aspectW }} / {{ $aspectH }};">
                <div class="absolute inset-0">
                    <template x-for="(src, i) in slides" :key="i">
                        <img
                            x-show="index === i"
                            :src="src"
                            class="absolute inset-0 w-full h-full object-cover"
                            x-transition.opacity
                        >
                    </template>
                </div>
            </div>

            <div class="absolute inset-y-0 left-2 flex items-center">
                <button type="button" @click="prev()" class="p-2 rounded-full bg-white/80 dark:bg-gray-800/80 shadow hover:bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
            </div>
            <div class="absolute inset-y-0 right-2 flex items-center">
                <button type="button" @click="next()" class="p-2 rounded-full bg-white/80 dark:bg-gray-800/80 shadow hover:bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>

            <div class="absolute inset-x-0 bottom-3 flex justify-center gap-2">
                <template x-for="(s, i) in slides" :key="'dot-'+i">
                    <button
                        type="button"
                        class="w-2.5 h-2.5 rounded-full"
                        :class="index === i ? 'bg-amber-500' : 'bg-white/70'"
                        @click="index = i"></button>
                </template>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
