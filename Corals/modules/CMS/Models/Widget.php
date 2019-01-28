<?php

namespace Corals\Modules\CMS\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Widget extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.widget';

    protected static $logAttributes = ['title'];

    protected $guarded = ['id'];

    protected $table = 'cms_widgets';

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * @return string
     * @throws FatalThrowableError
     * @throws \Exception
     */
    public function getRenderedAttribute()
    {
        $__data['__env'] = app(\Illuminate\View\Factory::class);
        extract($__data);
        $obLevel = ob_get_level();
        ob_start();
        $content = $this->attributes['content'];

        $content = str_ireplace(array('<?php', '@php', '<?', '@endphp', '?>'), array('&lt;?php', '&lt;?PHP', '&lt;?', '&gt;?php', '?&gt;'), $content);

        $php = \Blade::compileString($content);
        try {
            eval('?' . '>' . $php);
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }
}

