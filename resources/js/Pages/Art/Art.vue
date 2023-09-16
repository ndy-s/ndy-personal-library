<template>
    <Layout>
        <section class="mt-24">
            <div class="container mx-auto px-4">
                <h2 class="text-white text-4xl font-bold mb-8">My Library</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <Link href="art/library">
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <img src="https://images.tokopedia.net/img/cache/700/product-1/2017/5/21/670934/670934_4bad1661-f5f4-4fb0-af10-ad905dcac877.jpg" alt="Project 1" class="w-full h-64 object-cover object-center">
                            <div class="p-4 text-center">
                                <h3 class="text-xl font-bold mb-2 text-white">Art Library</h3>
                                <p class="text-gray-300">A collection of illustrations, production books, and more!</p>
                            </div>
                        </div>
                    </Link>

                    <Link href="art/tutorial">
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <img src="https://storage.googleapis.com/static.fastcampus.co.kr/prod/uploads/202206/042405-569/us-media-havtza-coursecard.png?w=384&q=75" alt="Project 1" class="w-full h-64 object-cover object-center">
                            <div class="p-4 text-center">
                                <h3 class="text-xl font-bold mb-2 text-white">Video Tutorials</h3>
                                <p class="text-gray-300">A collection of art and animation tutorials!</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <section class="mt-12">
            <div class="container mx-auto px-4">
                <h2 class="text-white text-4xl font-bold mb-8">Administrator Configuration</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <Link href="art/libraryconfiguration">
                        <div class="bg-gray-900 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <div class="p-4 text-center">
                                <h3 class="text-xl font-bold mb-2 text-white">Art Library Configuration</h3>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </Layout>
</template>
<script setup>
    import Layout from "../../Shared/Layout.vue";
</script>
