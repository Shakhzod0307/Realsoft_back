<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Text::create([
            'heading'=>'RealSoft - где идеи превращаются в реальность',
            'text'=>'Высокое качество продукта, <br> знание рынка и профессионализм <br> в управлении проектами',
            'type'=>'hero',
        ]);
        Text::create([
            'title'=>'Услуги',
            'heading'=>'Наши <span>Услуги</span> предлагают',
            'type'=>'service',
        ]);
        Text::create([
            'title'=>'Портфолио',
            'heading'=>'<span>Проекты, </span>которые мы реализовали',
            'type'=>'portfolio',
        ]);
        Text::create([
            'title'=>'О НАС',
            'heading'=>'КОМПАНИЯ <span>REALSOFT</span>',
            'text'=>'
          RealSoft — ведущий поставщик IT-решений с подтвержденным опытом предоставления передовых технологических решений. Более 20 лет мы
          оказываем предприятия различных отраслей нашей экспертизы в разработке индивидуального программного обеспечения: веб- и
          мобильных приложений, облачных вычислений, управления базами данных и многого другого.<br><br>
          Наша миссия — содействовать цифровому преобразованию и помогать предприятиям процветать в стремительно меняющемся цифровом ландшафте.
        <br><br>
          Мы гордимся своим богатым опытом и успешным завершением множества проектов для широкого круга клиентов. С командой высококвалифицированных
          и преданных специалистов мы стремимся предоставлять решения, разработанные под уникальные потребности наших клиентов. Наша
          стремление к отличию принесло нам лояльную клиентскую базу и признание за выдающиеся услуги.',
            'type'=>'company',
        ]);

        Text::create([
            'title'=>'СТАТИСТИКА',
            'heading'=>'REALSOFT - ЭТО МИРОВОЙ <span>ПОСТАВЩИК</span> ИТ-РЕШЕНИЙ',
            'text'=>'RealSoft - это мировой поставщик ИТ-решений и услуг с производственными центрами в Узбекистане и филиалами в Великобритании, Соединенных Штатах, Малайзии и Объединенных Арабских Эмиратах. Наш экосистема услуг по технологиям от конечной разработки программного обеспечения до конечных услуг тестирования и обеспечения качества включает в себя:',
            'type'=>'statistic',
        ]);
        Text::create([
            'title'=>'Секторы',
            'heading'=>'Секторы, в которых мы <span>оказываем</span> услуги',
            'type'=>'sector',
        ]);
        Text::create([
            'title'=>'преимущества',
            'heading'=>'Почему <span>REALSOFT?</span>',
            'type'=>'advantage',
        ]);
        Text::create([
            'title'=>'ТЕХНИЧЕСКАЯ ПОДДЕРЖКА',
            'heading'=>'ОСТАВИТЬ <span>ЗАЯВКУ</span>',
            'type'=>'form',
        ]);
        Text::create([
            'title'=>'команда',
            'heading'=>'НАША <span>команда</span> ',
            'type'=>'team',
        ]);
        Text::create([
            'title'=>'Блог',
            'heading'=>'Последние <span>статьи</span>',
            'type'=>'blog',
        ]);
        Text::create([
            'title'=>'Партнеры',
            'heading'=>'нам <span>доверяют</span>',
            'type'=>'partner',
        ]);
    }
}
