<template>
    <Layout>
        <template #nav>
            <Nav />
        </template>

        <section class="mt-24">
            <div class="container mx-auto px-4">
                <h2 class="text-white text-3xl font-bold mb-6 border-l-4 border-green-400 pl-4">Art Collection</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <HomeCard
                        artHomeLink="art-library"
                        artHomeImage="https://images.tokopedia.net/img/cache/700/product-1/2017/5/21/670934/670934_4bad1661-f5f4-4fb0-af10-ad905dcac877.jpg"
                        artHomeAlt="Art Library"
                    >
                        <template #default>Art Library</template>
                        <template #content>A collection of illustrations, production books, and more!</template>
                    </HomeCard>

                    <HomeCard
                        artHomeLink="art-course"
                        artHomeImage="https://storage.googleapis.com/static.fastcampus.co.kr/prod/uploads/202206/042405-569/us-media-havtza-coursecard.png?w=384&q=75"
                        artHomeAlt="Art Course"
                    >
                        <template #default>Art Course</template>
                        <template #content>A collection of art and animation courses!</template>
                    </HomeCard>

                    <HomeCard
                        artHomeLink="art-tutorial-book"
                        artHomeImage="https://i.ebayimg.com/images/g/akEAAOSwnBRgLJIm/s-l1200.webp"
                        artHomeAlt="Art Course"
                    >
                        <template #default>Art Tutorial Book</template>
                        <template #content>A collection of art and animation tutorial books!</template>
                    </HomeCard>
                </div>
            </div>
        </section>
    </Layout>
</template>
<script setup>
    import Layout from "@/Shared/Layout.vue";
    import Nav from "@/Shared/Nav.vue";
    import HomeCard from "@/Shared/HomeCard.vue";
</script>

