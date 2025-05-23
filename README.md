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
18. Создание контроллеров  php artisan make:controller Api/CategoryController --api /php artisan make:controller Api/ProductController --api
19. Пропиши маршруты (routes)  use App\Http\Controllers\Api\CategoryController;
                                use App\Http\Controllers\Api\ProductController;
                                
                                Route::apiResource('categories', CategoryController::class);
                                Route::apiResource('products', ProductController::class);

20. Создай Form Request для валидации  php artisan make:request StoreCategoryRequest
                                        php artisan make:request UpdateCategoryRequest
                                        php artisan make:request StoreProductRequest
                                        php artisan make:request UpdateProductRequest
    21. class StoreCategoryRequest extends FormRequest   public function rules(): array
                                                            {
                                                                return [
                                                                'name' => 'required|string|min:2',
                                                            ];
                                    class StoreProductRequest extends FormRequest                        }
                                          public function rules(): array
                                            {
                                                return [
                                                    return [
                                                'name' => 'required|string|min:2',
                                                'price' => 'required|numeric|min:0', // цена не может быть отрицательной
                                                'barcode' => [
                                                    'required',
                                                    'string',
                                                    'size:13', // EAN-13 – 13 символов
                                                    'unique:products,barcode',
                                                    'regex:/^\d{13}$/', // только цифры, 13 штук
                                                ],
                                                'category_id' => 'required|exists:categories,id', // категория должна существовать
                                            ];
                                                ];
                                            }
22. Создай API Resources php artisan make:resource CategoryResource php artisan make:resource ProductResource
23. Реализуй методы в контроллерах {
                                    public function index()
                                        {
                                            return CategoryResource::collection(Category::all());
                                        }
                                
                                public function store(StoreCategoryRequest $request)
                                        {
                                            $category = Category::create($request->validated());
                                            return new CategoryResource($category);
                                        }
                                
                                public function show(Category $category)
                                        {
                                            return new CategoryResource($category);
                                        }
                                
                                public function update(UpdateCategoryRequest $request, Category $category)
                                        {
                                            $category->update($request->validated());
                                            return new CategoryResource($category);
                                        }
                                
                                public function destroy(Category $category)
                                        {
                                            $category->delete();
                                            return response()->json(null, 204);
                                        }
                                }
    24. class ProductController extends Controller
                          {
                          use App\Http\Requests\StoreProductRequest;
                          use App\Http\Requests\UpdateProductRequest;
                          use App\Http\Resources\ProductResource;
                          use App\Models\Product;
                          
                          public function index()
                          {
                              return ProductResource::collection(Product::with('category')->get());
                          }
                          
                          public function store(StoreProductRequest $request)
                          {
                              $product = Product::create($request->validated());
                              $product->load('category'); // загружаем категорию
                              return new ProductResource($product);
                          }
                          
                          // реализуй show, update, destroy аналогично CategoryController
                          }
    25. Подключи  моделей class Category extends Model
                            {
                                public function products()
                            {
                                return $this->hasMany(Product::class);
                            }
                            }

                  class Product extends Model
                  {
                      use HasFactory;
                  
                      public function category()
                          {
                              return $this->belongsTo(Category::class);
                          }
                  }
26. Работа с whenLoaded()
27. Проверка через Postman
a) Запусти сервер Laravel

php artisan serve
Адрес по умолчанию: http://127.0.0.1:8000

b) Настрой запросы в Postman
GET http://127.0.0.1:8000/api/categories
Получить список категорий

28. 1. Установка maatwebsite/excel composer require maatwebsite/excel
29. Настройка очередей
a) Включите очереди через базу: В .env: QUEUE_CONNECTION=database
30  Создайте таблицу очереди:
                php artisan queue:table
                php artisan migrate
31  Запустите воркер (в отдельной вкладке терминала):php artisan queue:work
32. Чтобы использовать очереди в Laravel через базу данных, в файле .env пропишите: QUEUE_CONNECTION=database
33. php artisan make:export ProductsExport --model=Product  Создайте класс экспорта, который определяет, какие данные и в каком виде попадут в Excel.
34. В контроллере добавьте действие для скачивания Excel-файла: use App\Exports\ProductsExport;
                                use Maatwebsite\Excel\Facades\Excel;
                                public function exportExcel()
                                {
                                    return Excel::download(new ProductsExport, 'products.xlsx');
                                }
35. В routes/api.php   Route::get('products/export', [ProductController::class, 'exportExcel']);
36. php artisan make:job ExportProductsToExcel Сгенерируйте Job-класс    <?php

                                    namespace App\Jobs;
                                    
                                    use App\Exports\ProductsExport;
                                    use Illuminate\Bus\Queueable;
                                    use Illuminate\Contracts\Queue\ShouldQueue;
                                    use Illuminate\Foundation\Bus\Dispatchable;
                                    use Illuminate\Queue\InteractsWithQueue;
                                    use Illuminate\Queue\SerializesModels;
                                    use Illuminate\Support\Facades\Storage;
                                    use Maatwebsite\Excel\Facades\Excel;
                                    
                                    class ExportProductsToExcel implements ShouldQueue
                                    {
                                        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
                                    
                                        public $filePath;
                                    
                                        /**
                                         * Create a new job instance.
                                         *
                                         * @param string $filePath
                                         */
                                        public function __construct($filePath = 'exports/products.xlsx')
                                        {
                                            $this->filePath = $filePath;
                                        }
                                    
                                        /**
                                         * Execute the job.
                                         */
                                        public function handle()
                                        {
                                            // Сохраняем Excel в storage/app/exports/...
                                            Excel::store(new ProductsExport, $this->filePath, 'local');
                                            // Здесь можно добавить уведомление пользователю о готовности файла
                                        }
                                    }
37. В начале файла подключите ваш Job: use App\Jobs\ExportProductsToExcel;
38. Создайте сервис-файл app/Services/ProductService.php   namespace App\Services;

                                                            class ProductService
                                                            {
                                                                public function exportProductsToExcel()
                                                                {
                                                                    // Здесь ваша логика экспорта
                                                                }
                                                            
                                                                // Добавляйте другие методы для работы с товарами
                                                            }

39.Пропишите маршрут в routes/api.php   Route::get('products/export', [\App\Http\Controllers\Api\ProductController::class, 'exportExcel']);
40. Запустите очередь В отдельной вкладке терминала выполните:php artisan queue:work
41. проверяем на postman http://127.0.0.1:8080/api/products/export
42 Откройте в браузере/через Postman ваш маршрут для скачивания, например: http://127.0.0.1:8080/api/products/download/products_20250523_181348.xlsx  Если файл существует и очередь отработала — начнётся скачивание Excel-файла.

43 В терминале выполните php artisan serve
                    Убедитесь, что сервер запущен и отображает адрес и порт.
                    В Postman или браузере используйте именно этот адрес (и порт).
                    Если что-то не работает, скопируйте ошибку из терминала сюда — помогу разобратьс