<template>
    <v-app>
        <v-container>
            <router-view />
        </v-container>
    </v-app>
</template>

<script>
export default {
    name: "App",
};
</script>

<style>
.container {
    max-width: 100% !important;
}
.theme--light.v-application:has(#dashboard), #dashboard {
    background: #F5F6FB !important;
}
.theme--light.v-application:has(#dashboard) .card-title {
    color: #B622B5 !important;
    text-transform: capitalize;
    font-weight: bold;
    margin-bottom: 16px !important;
}
.theme--light.v-application:has(#dashboard) .card-title-more {
    display: flex;
    justify-content: space-between;
    text-transform: capitalize;
    font-weight: bold;
    margin-bottom: 8px !important;
    align-content: center;
    align-items: center;
}
.theme--light.v-application:has(#dashboard) .card-title-more h4:nth-of-type(2),
.theme--light.v-application:has(#dashboard) .card-title-more h4:nth-of-type(2) .v-icon {
    color: #B622B5 !important;
}
.theme--light.v-application:has(#dashboard) .card-title-more a h5 {
    border: 1px solid #B622B5;
    padding: 4px 8px;
    border-radius: 16px;
}
.theme--light.v-application:has(#dashboard) .card-title-more a h5,
.theme--light.v-application:has(#dashboard) .card-title-more a .v-icon {
    color: #B622B5 !important;
}
.theme--light.v-application:has(#dashboard) .card-title-more:not(.new) h4:nth-of-type(2) {
    display: none;
}
#dashboard .dashboard-main .v-main__wrap > .v-sheet.v-card:not(.v-sheet--outlined) {
    box-shadow: 0 0 24px 4px #eee;
}
#dashboard .dashboard-main .v-sheet.v-card:not(.v-sheet--outlined) {
    box-shadow: none;
}
.dashboard-dialog,
.dashboard-dialog .v-card {
    border-radius: 32px !important;
}
.v-btn {
    border-radius: 16px !important;
}

.theme--light.v-application:has(#auth) .container {
    padding: 0;
}

h1,
.h1,
h2,
.h2,
h3,
.h3,
h4,
.h4 {
    font-weight: 400;
    color: #000 !important;
}
h1,
.h1 {
    font-size: 3.2em !important;
}
h2,
.h2 {
    font-size: 2.6em !important;
}
h3,
.h3 {
    font-size: 1.825em !important;
    line-height: 1.4;
}
h4,
.h4 {
    font-size: 1.5em !important;
    font-weight: 600;
    line-height: 1.2em;
}
h5,
.h5 {
    font-size: 1.25em !important;
    font-weight: 400;
    line-height: 1.4em;
}
h6,
.h6 {
    font-size: 0.9em !important;
    font-weight: 600;
}
p {
    font-size: 16px !important;
    line-height: 1.4em;
    color: #000 !important;
}
h1 small,
h2 small,
h3 small,
h4 small,
h5 small,
h6 small,
.h1 small,
.h2 small,
.h3 small,
.h4 small,
.h5 small,
.h6 small,
h1 .small,
h2 .small,
h3 .small,
h4 .small,
h5 .small,
h6 .small,
.h1 .small,
.h2 .small,
.h3 .small,
.h4 .small,
.h5 .small,
.h6 .small,
.v-list-item__subtitle {
    font-weight: 300;
    line-height: 1.4em;
    color: #000 !important;
}
h1 small,
h2 small,
h3 small,
h1 .small,
h2 .small,
h3 .small {
    font-size: 60% !important;
    color: #000 !important;
}
</style>
