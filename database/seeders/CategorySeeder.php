<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'ثقافة عامة وإسلامية',
                'category_description' => 'أسئلة دينية وثقافية متنوعة تختبر معلوماتك الشاملة.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
            [
                'category_name' => 'العلوم والتكنولوجيا',
                'category_description' => 'عالم الفضاء، الكيمياء، الفيزياء، والتقنيات الحديثة والذكاء الاصطناعي.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
            [
                'category_name' => 'التاريخ والحضارات',
                'category_description' => 'سفر عبر الزمن لاستكشاف تاريخ الأمم والملوك والحضارات القديمة.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
            [
                'category_name' => 'الرياضة والبطولات',
                'category_description' => 'كرة القدم العالمية، الألعاب الأولمبية، وأساطير الرياضة عبر التاريخ.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
            [
                'category_name' => 'الجغرافيا والبلدان',
                'category_description' => 'العواصم، القارات، البحار، وأغرب المعالم الجغرافية حول العالم.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
            [
                'category_name' => 'الذكاء والألغاز',
                'category_description' => 'تحديات عقلية، ألغاز منطقية، وأسئلة ذكاء سريعة تنشط ذهنك.',
                'category_photo' => null,
                'special' => 'active',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['category_name' => $category['category_name']],
                $category
            );
        }
    }
}
