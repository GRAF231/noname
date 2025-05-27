# ACF Fields для темы Landscaping Theme

Этот каталог содержит JSON-файлы с настройками полей Advanced Custom Fields (ACF) для темы Landscaping Theme.

## Группы полей

### 1. Настройки главной страницы (group_home_page)

Поля для настройки главной страницы сайта:
- Слайдер на главной странице
- Преимущества компании
- Карта с отметками выполненных проектов

### 2. Настройки услуги (group_service)

Поля для настройки страницы услуги:
- Иконка услуги
- Краткое описание
- Особенности услуги
- Галерея работ
- Прайс-лист

### 3. Дополнительные поля товара (group_product)

Дополнительные поля для товаров WooCommerce:
- Технические характеристики
- Документы (сертификаты, инструкции)
- Видео
- Связанные услуги

### 4. Настройки темы (group_theme_settings)

Общие настройки темы:
- Контактная информация
- Социальные сети
- Текст в подвале
- Логотип

## Импорт полей

Для импорта полей в WordPress:

1. Установите и активируйте плагин Advanced Custom Fields PRO
2. Перейдите в раздел "Произвольные поля" -> "Инструменты"
3. Выберите "Импорт полей"
4. Загрузите файл acf-fields.json
5. Нажмите "Импорт"

## Автоматический импорт

Тема настроена на автоматическую синхронизацию полей ACF. При активации темы поля будут автоматически импортированы.

Для включения автоматической синхронизации добавьте следующий код в functions.php:

```php
// Автоматическая синхронизация полей ACF
add_filter('acf/settings/save_json', 'landscaping_theme_acf_json_save_point');
function landscaping_theme_acf_json_save_point($path) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'landscaping_theme_acf_json_load_point');
function landscaping_theme_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
```

## Использование полей в шаблонах

Примеры использования полей в шаблонах темы:

### Слайдер на главной странице

```php
<?php if (have_rows('hero_slides')) : ?>
    <div class="hero-slider">
        <?php while (have_rows('hero_slides')) : the_row(); ?>
            <div class="hero-slide" style="background-image: url('<?php echo esc_url(get_sub_field('slide_image')); ?>');">
                <div class="hero-content">
                    <h2><?php echo esc_html(get_sub_field('slide_title')); ?></h2>
                    <p><?php echo esc_html(get_sub_field('slide_description')); ?></p>
                    <?php if (get_sub_field('slide_button_text') && get_sub_field('slide_button_url')) : ?>
                        <a href="<?php echo esc_url(get_sub_field('slide_button_url')); ?>" class="btn"><?php echo esc_html(get_sub_field('slide_button_text')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
```

### Технические характеристики товара

```php
<?php if (have_rows('product_specifications')) : ?>
    <div class="product-specifications">
        <h3>Технические характеристики</h3>
        <table>
            <?php while (have_rows('product_specifications')) : the_row(); ?>
                <tr>
                    <th><?php echo esc_html(get_sub_field('specification_name')); ?></th>
                    <td><?php echo esc_html(get_sub_field('specification_value')); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
<?php endif; ?>
```

### Контактная информация

```php
<?php
$contact_info = get_field('contact_info', 'option');
if ($contact_info) :
?>
    <div class="contact-info">
        <p><strong>Адрес:</strong> <?php echo esc_html($contact_info['company_address']); ?></p>
        <p><strong>Телефон:</strong> <?php echo esc_html($contact_info['company_phone']); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($contact_info['company_email']); ?></p>
        <p><strong>Часы работы:</strong> <?php echo esc_html($contact_info['company_working_hours']); ?></p>
    </div>
<?php endif; ?>