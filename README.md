# SBI
test project
1. создал проект          composer create-project laravel/laravel inventory-manager 
3. пака .OSP прописал настройи
4. установил гит echo "# SBI" >> README.md
                  git init
                  git add README.md
                  git commit -m "first commit"
                  git branch -M main
                  git remote add origin https://github.com/ula123456/SBI.git
                  git push -u origin main
                  …or push an existing repository from the command line
                  git remote add origin https://github.com/ula123456/SBI.git
                  git branch -M main
                  git push -u origin main
   5. .env настройка базы 
6. Создание миграций и моделей Категория и товар php artisan make:model Category -m    / php artisan make:model Product -m
7. запустил php artisan migrate
8. создал Сидеры Seeder для категорий и продукт: php artisan make:seeder CategorySeeder  / 
9. содержимое Category::insert([
                                  ['name' => 'Смартфоны'],
                                  ['name' => 'Зарядки'],
                                  ['name' => 'Чехлы'],
                              ]);
   10. создал фабрика для товаров php artisan make:factory ProductFactory --model=Product содержание фабрики return [
                                                                    'name' => $this->faker->word(),
                                                                    'price' => $this->faker->randomFloat(2, 1000, 50000),
                                                                    'barcode' => $this->faker->unique()->ean13(),
                                                                    'category_id' => Category::inRandomOrder()->first()->id,
                                                                ];
   11. создал сидер для товаров php artisan make:seeder ProductSeeder
   12.  содержимое сидера Product::factory(200)->create();
   13.  Зарегистрируй сидер в главном DatabaseSeeder И добавь вызов ProductSeeder: public function run()
                                                                            {
                                                                                $this->call([
                                                                                    CategorySeeder::class,
                                                                                    ProductSeeder::class,
                                                                                ]);
                                                                            }

  14. Добавь импорт модели Category/ Product  use App\Models\Product;  use App\Models\Category;
  15.  В терминале выполни: php artisan db:seed
  16. app/Models/Product.php
                  namespace App\Models;
                  
                  use Illuminate\Database\Eloquent\Factories\HasFactory;
                  use Illuminate\Database\Eloquent\Model;
                  
                  class Product extends Model
                  {
                      use HasFactory;
                  
                      // остальные свойства и методы
                  }

17. database/factories/ProductFactory.php) указываем use App\Models\Category;


