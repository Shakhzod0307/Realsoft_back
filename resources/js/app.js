import './bootstrap';
import { createApp } from 'vue';
import BlogComponent from './components/BlogComponent.vue';
import ServiceComponent from './components/ServiceComponent.vue';
import SectorComponent from './components/SectorComponent.vue';
import FormComponent from "./components/FormComponent.vue";
import AdvantageComponent from "./components/AdvantageComponent.vue";
import TeamComponent from "./components/TeamComponent.vue";
import PartnerComponent from "./components/PartnerComponent.vue";
import StatisticComponent from "./components/StatisticComponent.vue";
import AboutComponent from "./components/AboutComponent.vue";
import ImageComponent from "./components/ImageComponent.vue";
import TextComponent from "./components/TextComponent.vue";

const app = createApp({});
app.component('service-component', ServiceComponent);
app.component('blog-component', BlogComponent);
app.component('sector-component', SectorComponent);
app.component('form-component', FormComponent);
app.component('advantage-component', AdvantageComponent);
app.component('team-component',TeamComponent);
app.component('partner-component',PartnerComponent);
app.component('statistic-component',StatisticComponent);
app.component('about-component',AboutComponent);
app.component('image-component',ImageComponent);
app.component('texts-component',TextComponent);
app.mount('#app');

