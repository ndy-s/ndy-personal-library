<template>
    <Layout>
        <section class="mt-24">
            <div class="container mx-auto px-4">
                <h2 class="flex items-center text-white text-3xl font-bold mb-6 border-l-4 border-custom-gainsboro pl-2">Art Collection</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <ArtHomeCard 
                        artHomeLink="art/library"
                        artHomeImage="https://images.tokopedia.net/img/cache/700/product-1/2017/5/21/670934/670934_4bad1661-f5f4-4fb0-af10-ad905dcac877.jpg"
                        artHomeAlt="Art Library"
                    >
                        <template #default>Art Library</template>
                        <template #content>A collection of illustrations, production books, and more!</template>
                    </ArtHomeCard>

                    <ArtHomeCard 
                        artHomeLink="art/tutorial"
                        artHomeImage="https://storage.googleapis.com/static.fastcampus.co.kr/prod/uploads/202206/042405-569/us-media-havtza-coursecard.png?w=384&q=75"
                        artHomeAlt="Art Course"
                    >
                        <template #default>Art Course</template>
                        <template #content>A collection of art and animation courses!</template>
                    </ArtHomeCard>
                </div>
            </div>
        </section>
    </Layout>
</template>
<script setup>
    import Layout from "@/Shared/Layout.vue";
    import ArtHomeCard from "@/Shared/ArtHomeCard.vue";
</script>

