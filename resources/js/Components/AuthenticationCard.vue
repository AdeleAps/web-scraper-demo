<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 bg-main-dark"
    >
        <div
            class="w-full h-full relative group sm:max-w-md mt-6 px-6 py-4 bg-main-light shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
