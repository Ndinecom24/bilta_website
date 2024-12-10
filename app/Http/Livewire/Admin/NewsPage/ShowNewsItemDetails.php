<?php

namespace App\Http\Livewire\Admin\NewsPage;

use App\Models\Bilta\FAQs;
use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\News;
use App\Models\System\Status;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowNewsItemDetails extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $our_news_id, $details, $title, $short_description, $post_date, $author, $status_id, $created_by, $category_id;
    public $news_title_image, $news_image ;



    public $updateNewsItem = false;
    protected $listeners = [
        'deleteNews' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'title' => 'required',
        'details' => 'required',
        'short_description' => 'required',
        'post_date' => 'required',
        'author' => 'required',
        'news_title_image' =>  'required|mimes:png,jpg,jpeg|max:3072', // 3MB Max,
//        'news_title_image' => 'image|max:3072', // 1MB Max
    ];


    public function mount($id){
        $this->our_news_id = $id ;
    }
    public function render()
    {
        $our_news_item = News::findOrFail($this->our_news_id) ;
        $statuses = Status::get();
        $categories = ItemCategory::where('type', 'News')->get();
 
        return view('livewire.admin.news-page.show-news')->with(compact('our_news_item', 'statuses', 'categories'));
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {

            // Create NewsItem
            $news = News::updateOrCreate(
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'short_description' => $this->short_description,
                ],
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]

            );

            if (isset($this->news_title_image) ){
            $news->addMedia($this->news_title_image)
                -> toMediaCollection('news_title_images');
            }

                 //save other images
               if (isset($this->news_image) ){
                foreach(  $this->news_image as $item  ){
                    
                    // if ( $item->fileExists()) {
                            // $projects->clearMediaCollection('news_images');
                          $news->addMedia( $item )
                                -> toMediaCollection('news_images');
                        // }
                }
            }

            // Set Flash Message
            session()->flash('success', 'News Item Created Successfully!!');
            // Reset Form Fields After Creating NewsItem
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating news item!!' . $e->getMessage());
            // Reset Form Fields After Creating NewsItem
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->title = '';
        $this->details = '';
        $this->short_description = '';
        $this->post_date = '';
        $this->author = '';
        $this->category_id = '';
        $this->status_id = '';
        $this->news_title_image = null ;
    }

    public function edit($id)
    {
        $our_news = News::findOrFail($id);

     
        $this->news = $our_news;
        $this->title = $our_news->title;
        $this->details = $our_news->details;
        $this->post_date = $our_news->post_date;
        $this->author = $our_news->author;
        $this->short_description = $our_news->short_description;
        $this->category_id = $our_news->category_id;
        $this->status_id = $our_news->status_id;
        $this->our_news_id = $our_news->id;
        $this->updateNewsItem = true;
    }

    public function update()
    {
        // Validate request
        try {
            // Update our_news
            News::find($this->our_news_id)->fill(
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            $news = News::find($this->our_news_id) ;

            if (isset($this->news_title_image) ) {
                $news->clearMediaCollection('news_title_images');
              $news->addMedia( $this->news_title_image )
                    -> toMediaCollection('news_title_images');
            }

               //save other images
               if (isset($this->news_image) ){
                foreach(  $this->news_image as $item  ){
                    
                    // if ( $item->fileExists()) {
                            // $projects->clearMediaCollection('news_images');
                          $news->addMedia( $item )
                                -> toMediaCollection('news_images');
                        // }
                }
            }

            session()->flash('success', 'News Item Updated Successfully!!');

            $this->cancel();
        } catch (Exception $e) {
            session()->flash('error', 'Something goes wrong while updating news item!!');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->updateNewsItem = false;
        $this->resetFields();
    }


    public function destroy($id)
    {
        try {
            News::find($id)->delete();
            session()->flash('success', "News Item Deleted Successfully!!");
        } catch (Exception $e) {
            session()->flash('error', "Something goes wrong while deleting news item!!");
        }

    }

    
    public function removeImage($item){
        Media::find( $item )->delete();
        $this->news  = News::find($this->our_news_id );
        session()->flash('success', "News Image Deleted Successfully!!");
    }


}
