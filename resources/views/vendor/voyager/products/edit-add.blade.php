@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <form role="form" class="form-edit-add" id="removeVVVV" action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}" method="POST" enctype="multipart/form-data">
        
          <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif

            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
        
            <div class="row">
                <div class="col-md-8">
                    
                        <div class="panel">
                           
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="voyager-character"></i> Title
                                    <span class="panel-desc"> Title of your product </span>
                                </h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('voyager::generic.name') }}" value="{{ $dataTypeContent->name ?? '' }}">
                            </div>
                        </div>
    
                    <div class="panel panel-bordered">
                        <!-- form start -->
                       
                      
    
                            <div class="panel-bod" style="margin-top:20px">
    
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
    
                                <!-- Adding / Editing -->
                                @php
                                    $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                @endphp
    
                                @foreach($dataTypeRows as $row)
                                    <!-- GET THE DISPLAY OPTIONS -->
                                    @php
                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                         $shouldHideFieldName = $row->field === 'name';
                                         $shouldHideFieldSlug = $row->field === 'slug';
                                         $shouldHideFieldStatus = $row->field === 'status';
                                         $shouldHideFieldFeatured = $row->field === 'featured';
                                         $shouldHideFieldMetaDes = $row->field === 'meta_description';
                                         $shouldHideFieldMetaKey = $row->field === 'meta_keywords';
                                         $shouldHideFieldSKU = $row->field === 'SKU';
                                         $shouldHideFieldPrice = $row->field === 'regular_price';
                                         $shouldHideFieldis_3d = $row->field === 'is_3d';
                                         $shouldHideFieldStock_status = $row->field === 'stock_status';
                                         $shouldMoveFieldobject_id =  $row->type === 'relationship';
                                         $shouldMoveFieldobject_idImages = $row->field === 'images';
                                         
                                    @endphp
                                    @if (isset($row->details->legend) && isset($row->details->legend->text))
                                        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                    @endif
    
                                    @if (!$shouldHideFieldName && !$shouldHideFieldSlug && !$shouldHideFieldStatus && !$shouldHideFieldFeatured && !$shouldHideFieldMetaDes && !$shouldHideFieldMetaKey && !$shouldHideFieldSKU && !$shouldHideFieldPrice && !$shouldHideFieldis_3d && !$shouldMoveFieldobject_id && !$shouldHideFieldStock_status && !$shouldMoveFieldobject_idImages)
       

    
                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if ($add && isset($row->details->view_add))
                                            @include($row->details->view_add, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'add', 'options' => $row->details])
                                        @elseif ($edit && isset($row->details->view_edit))
                                            @include($row->details->view_edit, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'edit', 'options' => $row->details])
                                        @elseif (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif
    
                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                    @endif
                                @endforeach
    
                            </div><!-- panel-body -->
    
                            <div class="panel-footer">
                                @section('submit-buttons')
                                    <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                @stop
                                @yield('submit-buttons')
                            </div>
                            
                        <div style="display:none">
                            <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
                            <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-clipboard"></i> Product Details</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                               
                               <div class="form-group">
                                    <label for="slug">URL Slug</label>
                               
                                    <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="slug"
                                    {!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}
                                    value="{{ $dataTypeContent->slug ?? '' }}">
                                </div>
                                
                                
                               <div class="form-group">
                                    <label for="meta_description">SKU</label>
                               
                                    <input class="form-control" name="SKU" value="{{ $dataTypeContent->SKU ?? '' }}" >
                                </div>
                                
                                <!--<div class="form-group">-->
                                <!--    <label for="meta_description">Price</label>-->
                               
                                <!--    <input class="form-control" name="regular_price" value="{{ $dataTypeContent->regular_price ?? '' }}" >-->
                                <!--</div>-->
                                
                                
                            
                                
                                <div class="form-group">
                                    <label for="status">Product Status</label>
                                    <select class="form-control" name="status">
                                        <option value="PUBLISHED"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PUBLISHED') selected="selected"@endif>{{ __('voyager::post.status_published') }}</option>
                                        <option value="DRAFT"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'DRAFT') selected="selected"@endif>{{ __('voyager::post.status_draft') }}</option>
                                        <option value="PENDING"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PENDING') selected="selected"@endif>{{ __('voyager::post.status_pending') }}</option>
                                    </select>
                                </div>
                                
                                
                             
                                
                              
                                
                              
                                @foreach($dataTypeRows as $row)
                                 @php

                                    $shouldMoveFieldis_3d = $row->field === 'is_3d';
                                    $shouldMoveFieldis_3dStock_status = $row->field === 'stock_status';
                                    $shouldMoveFieldobject_id =  $row->type === 'relationship';
                                    
                                @endphp
                                
                               
                                @if ($shouldMoveFieldis_3dStock_status || $row->field === 'featured' || $shouldMoveFieldis_3d)
                                    <!-- Move this field to a different location within the form -->
                                    <div class="form-group">
                                        <label class="control-label" for="{{ $row->field }}">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                            
                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                   
                                @endif
                                
                            
                                
                                @if($shouldMoveFieldobject_id)
                                
                                <!-- Move this relationship field to a different location within the form -->
                                <div class="form-group">
                                    <label class="control-label" for="{{ $row->field }}">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::formfields.relationship', ['options' => $row->details])
                        
                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
        
                                @endif
                                
                            @endforeach
                              
                              
<!--                                 <button type="button" class="btn btn-primary w-100" id="add-variation-button">Add Variation</button>-->
<!--<div id="variations-container"></div>-->

@php  

 $productId = request()->route('product'); // 'product' is the name of the route parameter
    // Or, if the route parameter is not named, you can use the segment method
   
    $productId = request()->segment(3);
    
    
    $variations = DB::table('product_variations')->where('product_id',$productId)->get(); 
    
@endphp

<button type="button" class="btn btn-primary w-100" id="add-variation-button">Add Variation</button>

@if(isset($variations) && $variations->count() > 0)
    <h3>Variations</h3>
@endif

<table class="table table-bordered" id="variations-container">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th> {{-- Actions column --}}
        </tr>
    </thead>
    <tbody>
        @foreach($variations as $variation)
            <tr id="variation-row-{{ $variation->id }}">
                <td>
                    <input type="text" name="variations[{{ $variation->id }}][name]" value="{{ $variation->name }}" class="form-control" />
                </td>
                <td>
                    <input type="number" name="variations[{{ $variation->id }}][price]" value="{{ $variation->price }}" class="form-control" />
                </td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeVariationRow('variation-row-{{ $variation->id }}')">Remove</button>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>


                                
                            </div>
                        </div>
                        
                        
                        <!-- ### IMAGE ### -->
                        <div class="panel panel-bordered panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> Product Images</h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <!--images[]-->
                                
                                
                                @foreach($dataTypeRows as $row)
                                 @php

                                    $shouldMoveFieldImages = $row->field === 'images';
                                    
                                @endphp
                                
                               
                                @if ($shouldMoveFieldImages)
                                    <!-- Move this field to a different location within the form -->
                                    <div class="form-group">
                                        <label class="control-label" for="{{ $row->field }}">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                            
                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                   
                                @endif
                                
                            
                                
                            @endforeach
                            
                            </div>
                        </div>
                        
                         <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> {{ __('voyager::post.seo_content') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                               
                                <textarea class="form-control" name="meta_description">{{ $dataTypeContent->meta_description ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                               
                                <textarea class="form-control" name="meta_keywords">{{ $dataTypeContent->meta_keywords ?? '' }}</textarea>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            userId = '{{Auth::user()->id}}'

            $('select[name="sub_category_id"]').on('change', function(){    
  

  $('input[name=sub_category_id]').val($(this).val());
  $('input[name=user_id]').val(userId);
});

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
        
//         document.addEventListener('DOMContentLoaded', function() {
//     const variationsContainer = document.getElementById('variations-container');
//     const addVariationButton = document.getElementById('add-variation-button');

//     addVariationButton.addEventListener('click', function() {
//         const newIndex = variationsContainer.children.length;
//         const variationGroup = document.createElement('div');
//         variationGroup.innerHTML = `
//             <div class="variation-group" id="variation-group-${newIndex}">
//                 <input type="text" name="variations[${newIndex}][name]" placeholder="Variation Name" />
//                 <input type="number" name="variations[${newIndex}][price]" placeholder="Price" step="0.01" />
//                 <button type="button" onclick="removeVariation(${newIndex})">Remove</button>
//             </div>
//         `;
//         variationsContainer.appendChild(variationGroup);
//     });
// });

// function removeVariation(index) {
//     const variationGroup = document.getElementById('variation-group-' + index);
//     variationGroup.remove();
// }


document.addEventListener('DOMContentLoaded', function() {
    const variationsContainer = document.querySelector('#variations-container tbody');
    const addVariationButton = document.getElementById('add-variation-button');

    addVariationButton.addEventListener('click', function() {
        const newIndex = variationsContainer.children.length;
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <input type="text" name="variations[new_${newIndex}][name]" placeholder="Variation Name" class="form-control" />
            </td>
            <td>
                <input type="number" name="variations[new_${newIndex}][price]" placeholder="Price" step="0.01" class="form-control" />
            </td>
            <td>
                <button type="button"  class="btn btn-danger" onclick="removeVariation(this)">Remove</button>
            </td>
        `;
        variationsContainer.appendChild(newRow);
    });
});

function removeVariation(element) {
    element.closest('tr').remove();
}

// function removeVariationRow(rowId) {
//     const row = document.getElementById(rowId);
//     if (row) {
//         row.remove();
//     }
// }

function removeVariationRow(rowId) {
    const variationId = rowId.split('-').pop(); // Extract the variation ID from the rowId
    const row = document.getElementById(rowId);
    
    if (row) {
        // Create a hidden input for marking the variation as deleted
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_variations[]';
        input.value = variationId;

        // Append the hidden input to the form
        const form = document.getElementById('removeVVVV'); // Replace with your actual form ID
        form.appendChild(input);

        // Remove the row from the table
        row.remove();
    }
}


    </script>
@stop
