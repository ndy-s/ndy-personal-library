<template>
    <div>
        <Nav />

        <main>
            <section class="py-8">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold mb-8">Welcome to NdyApp!</h2>
                    <p class="text-lg text-gray-900 mb-8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non feugiat nibh. Sed vel eros enim.</p>
                    <div class="flex items-center space-x-4">
                        <button class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-full text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">Download CV</button>
                        <button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-full text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">Contact Me</button>
                    </div>
                </div>
            </section>

            <section class="mt-12">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold mb-8">My Projects</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <img src="project-1.jpg" alt="Project 1" class="w-full h-64 object-cover object-center">
                            <div class="p-4">
                                <h3 class="text-xl font-bold mb-2 text-white">Project 1</h3>
                                <p class="text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <img src="project-2.jpg" alt="Project 2" class="w-full h-64 object-cover object-center">
                            <div class="p-4">
                                <h3 class="text-xl font-bold mb-2 text-white">Project 2</h3>
                                <p class="text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <img src="project-3.jpg" alt="Project 3" class="w-full h-64 object-cover object-center">
                            <div class="p-4">
                                <h3 class="text-xl font-bold mb-2 text-white">Project 3</h3>
                                <p class="text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <footer class="bg-transparent py-4">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-900">© 2023 My Unique Portfolio. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
    import Nav from "../Shared/Nav.vue"

</script>

<style scoped>
    button {
        transition-property: background-color, transform, box-shadow;
    }
</style>
