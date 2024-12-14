import './bootstrap';
import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
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
const messages = {
    en: {
        dashboard: {
            title: 'Blogs Dashboard',
            addBlog: 'Add Blog',
            searchPlaceholder: 'Search blogs...',
            confirmDelete: 'Are you sure you want to delete this blog?',
            confirmDeleteTitle: 'Confirm Delete',
            cancel: 'Cancel',
            save: 'Save',
            delete: 'Delete',
        },
        modal: {
            addBlogTitle: 'Add Blog',
            editBlogTitle: 'Edit Blog',
            contentPlaceholder: 'Content...',
            titlePlaceholder: 'Title...',
        },
    },
    ru: {
        dashboard: {
            title: 'Блоги',
            addBlog: 'Добавить Блог',
            searchPlaceholder: 'Поиск по блогам...',
            confirmDelete: 'Вы уверены, что хотите удалить этот блог?',
            confirmDeleteTitle: 'Подтвердить удаление',
            cancel: 'Отменить',
            save: 'Сохранить',
            delete: 'Удалить',
        },
        modal: {
            addBlogTitle: 'Добавить Блог',
            editBlogTitle: 'Редактировать Блог',
            contentPlaceholder: 'Содержание...',
            titlePlaceholder: 'Заголовок...',
        },
    },
    uz: {
        dashboard: {
            title: 'Bloglar Paneli',
            addBlog: 'Blog Qo\'shish',
            searchPlaceholder: 'Bloglarni izlash...',
            confirmDelete: 'Ushbu blogni o\'chirishni xohlaysizmi?',
            confirmDeleteTitle: 'O\ʻchirishni tasdiqlang',
            cancel: 'Bekor qilish',
            save: 'Saqlash',
            delete: 'O\'chirish',
        },
        modal: {
            addBlogTitle: 'Blog Qo\'shish',
            editBlogTitle: 'Blogni Tahrirlash',
            contentPlaceholder: 'Kontent...',
            titlePlaceholder: 'Sarlavha...',
        },
    },
};

const i18n = createI18n({
    locale: 'en',
    messages,
});

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
app.use(i18n);
app.mount('#app');

