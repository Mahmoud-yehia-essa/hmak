<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'ثقافة عامة وإسلامية' => [
                [
                    'qu_title' => 'ما هي السورة التي تلقب بقلب القرآن؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'سورة يس',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'كم عدد سور القرآن الكريم؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => '114 سورة',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو الصحابي الذي لُقب بـ ذي النورين؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'عثمان بن عفان',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هي أطول سورة في القرآن الكريم؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'سورة البقرة',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'في أي سنة هجرية وقعت غزوة بدر الكبرى؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => '2 هـ',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو أول من أذن في الإسلام؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'بلال بن رباح',
                    'answer_type' => 'text',
                ],
            ],
            'العلوم والتكنولوجيا' => [
                [
                    'qu_title' => 'ما هو الكوكب الأحمر في مجموعتنا الشمسية؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'كوكب المريخ',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو الرمز الكيميائي للماء؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'H2O',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو أسرع شيء في الكون؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الضوء',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو الغاز الأساسي الذي يمتصه النبات في عملية البناء الضوئي؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'ثاني أكسيد الكربون',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو مخترع المصباح الكهربائي؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'توماس إديسون',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هي أكبر غدة في جسم الإنسان؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الكبد',
                    'answer_type' => 'text',
                ],
            ],
            'التاريخ والحضارات' => [
                [
                    'qu_title' => 'أين بنيت الأهرامات الثلاثة الشهيرة؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الجيزة، مصر',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو القائد المسلم الذي فتح الأندلس؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'طارق بن زياد',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'أي حضارة قديمة بنيت سور الصين العظيم؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الحظارة الصينية',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'في أي مدينة تأسست الدولة الأموية؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'دمشق',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو القائد الذي أسس الدولة المغولية؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'جنكيز خان',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'في أي عام سقطت القسطنطينية؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => '1453 م',
                    'answer_type' => 'text',
                ],
            ],
            'الرياضة والبطولات' => [
                [
                    'qu_title' => 'كم عدد لاعبي فريق كرة القدم داخل الملعب؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => '11 لاعباً',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'كل كم سنة تقام بطولة كأس العالم لكرة القدم؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => '4 سنوات',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هي الدولة الأكثر فوزاً بكأس العالم لكرة القدم؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'البرازيل',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'أين أقيمت أول الألعاب الأولمبية الحديثة عام 1896؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'أثينا، اليونان',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'من هو اللاعب التاريخي الذي يلقب بـ الجوهرة السوداء؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'بيليه',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'أي نادٍ أوروبي حقق لقب دوري أبطال أوروبا لأول مرة في تاريخه عام 1956؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'ريال مدريد',
                    'answer_type' => 'text',
                ],
            ],
            'الجغرافيا والبلدان' => [
                [
                    'qu_title' => 'ما هي عاصمة جمهورية مصر العربية؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'القاهرة',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو أكبر محيط في العالم؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'المحيط الهادئ',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هي أصغر دولة في العالم من حيث المساحة؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الفاتيكان',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو أطول نهر في العالم؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'نهر النيل',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'في أي قارة تقع جبال الأنديز؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'أمريكا الجنوبية',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هي عاصمة أستراليا؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'كانبرا',
                    'answer_type' => 'text',
                ],
            ],
            'الذكاء والألغاز' => [
                [
                    'qu_title' => 'ما هو الشيء الذي يكتب ولا يقرأ؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'القلم',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو الشيء الذي كلما أخذت منه كبر؟',
                    'qu_points' => 200,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الحفرة',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو الشيء الذي له أسنان ولا يعض؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'المشط',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو الشيء الذي يمشي ويقف وليس له أرجل؟',
                    'qu_points' => 400,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'الساعة',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ما هو البيت الذي ليس فيه أبواب ولا نوافذ؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'بيت الشعر',
                    'answer_type' => 'text',
                ],
                [
                    'qu_title' => 'ابن أمك وابن أبيك، وليس بأختك ولا بأخيك، فمن يكون؟',
                    'qu_points' => 600,
                    'time_counter' => 30,
                    'questions_type' => 'text',
                    'answer_title' => 'أنت',
                    'answer_type' => 'text',
                ],
            ],
        ];

        foreach ($data as $catName => $questions) {
            $category = Category::where('category_name', $catName)->first();
            if (!$category) {
                continue;
            }

            foreach ($questions as $q) {
                // Create or update the question
                $question = Question::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'qu_title' => $q['qu_title']
                    ],
                    [
                        'qu_points' => $q['qu_points'],
                        'time_counter' => $q['time_counter'],
                        'questions_type' => $q['questions_type'],
                    ]
                );

                // Create or update the answer linked to this question
                Answer::updateOrCreate(
                    [
                        'question_id' => $question->id,
                    ],
                    [
                        'answer_title' => $q['answer_title'],
                        'answer_type' => $q['answer_type'],
                    ]
                );
            }
        }
    }
}
