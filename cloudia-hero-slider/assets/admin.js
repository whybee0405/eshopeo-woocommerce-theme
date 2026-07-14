(function ($) {
  'use strict';

  var PRESETS = {
    branch: {
      badge_label: 'Branch page',
      eyebrow: 'Local branch support',
      heading: 'Speak to your nearest Parts-Mall branch.',
      body: 'Use this slide for local campaigns with clear direction, call, and enquiry paths.',
      cta_label: 'Get directions',
      secondary_cta_label: 'Call branch',
      text_align: 'left',
      is_active: true
    },
    wholesale: {
      badge_label: 'Trade supply',
      eyebrow: 'Wholesale support',
      heading: 'Trade, workshop, and fleet supply.',
      body: 'Use this layout for B2B campaigns with stronger procurement and account-opening hooks.',
      cta_label: 'Request wholesale pricing',
      secondary_cta_label: 'Talk to sales',
      text_align: 'left',
      is_active: true
    },
    campaign: {
      badge_label: 'Seasonal campaign',
      eyebrow: 'Limited-time promotion',
      heading: 'Promote a focused offer without rewriting the whole module.',
      body: 'Use short copy, one clear offer, and a second CTA for fallback traffic.',
      cta_label: 'View offer',
      secondary_cta_label: 'Contact us',
      text_align: 'center',
      is_active: true
    }
  };

  function relabel($editor) {
    $editor.find('[data-chs-slide-panel]').each(function (index) {
      var $panel = $(this);
      $panel.attr('data-index', index);
      $panel.find('[name]').each(function () {
        var name = $(this).attr('name');
        $(this).attr('name', name.replace(/chs_slides\[[^\]]+\]/, 'chs_slides[' + index + ']'));
      });
      $editor.find('[data-chs-slide-tab]').eq(index).attr('data-chs-slide-tab', index);
      var heading = $panel.find('[data-chs-slide-heading]').val() || ('Slide ' + (index + 1));
      var $tab = $editor.find('[data-chs-slide-tab]').eq(index);
      $tab.find('.chs-slide-list__label').text(heading);
      $tab.toggleClass('is-inactive', !$panel.find('[data-chs-slide-active]').is(':checked'));
      $tab.find('.chs-slide-list__meta').text($panel.find('[data-chs-slide-badge]').val() || 'No badge');
    });
  }

  function previewText(value, fallback) {
    return value && value.trim() ? value.trim() : fallback;
  }

  function syncPreview($panel) {
    var badge = $panel.find('[data-chs-slide-badge]').val();
    var eyebrow = $panel.find('[data-chs-slide-eyebrow]').val();
    var heading = $panel.find('[data-chs-slide-heading]').val();
    var body = $panel.find('[data-chs-slide-body]').val();
    var primary = $panel.find('[data-chs-slide-primary-label]').val();
    var secondary = $panel.find('[data-chs-slide-secondary-label]').val();
    var align = $panel.find('[data-chs-slide-align]').val() || 'inherit';
    var active = $panel.find('[data-chs-slide-active]').is(':checked');

    $panel.find('[data-chs-preview-badge]').text(previewText(badge, '')).toggle(!!previewText(badge, ''));
    $panel.find('[data-chs-preview-eyebrow]').text(previewText(eyebrow, 'Eyebrow text'));
    $panel.find('[data-chs-preview-heading]').text(previewText(heading, 'Slide heading'));
    $panel.find('[data-chs-preview-body]').text(previewText(body, 'Short supporting copy appears here.'));
    $panel.find('[data-chs-preview-primary]').text(previewText(primary, 'Primary CTA'));
    $panel.find('[data-chs-preview-secondary]').text(previewText(secondary, 'Secondary CTA')).toggle(!!previewText(secondary, ''));
    $panel.find('[data-chs-preview-align]').attr('data-chs-preview-align', align);
    $panel.find('[data-chs-preview-status]').text(active ? 'Active' : 'Inactive').toggleClass('is-active', active);
  }

  function setField($panel, key, value) {
    var $field = $panel.find('[name$="[' + key + ']"]');
    if (!$field.length) return;
    if ($field.is(':checkbox')) {
      $field.prop('checked', !!value);
    } else {
      $field.val(value);
    }
  }

  function applyPreset($panel, presetName) {
    var preset = PRESETS[presetName];
    if (!preset) return;
    Object.keys(preset).forEach(function (key) {
      setField($panel, key, preset[key]);
    });
    syncPreview($panel);
    relabel($panel.closest('[data-chs-editor]'));
  }

  function bindMedia($root) {
    $root.find('[data-chs-media-open]').off('click').on('click', function () {
      var $field = $(this).closest('.chs-media-field');
      var frame = wp.media({ title: 'Choose Image', button: { text: 'Use image' }, multiple: false });
      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        $field.find('[data-chs-media-id]').val(attachment.id);
        $field.find('[data-chs-media-preview]').html('<img src="' + attachment.url + '" alt="">');
        if ($field.attr('data-chs-media-role') === 'desktop') {
          $field.closest('[data-chs-slide-panel]').find('[data-chs-preview-media]').html('<img src="' + attachment.url + '" alt="">');
        }
      });
      frame.open();
    });

    $root.find('[data-chs-media-clear]').off('click').on('click', function () {
      var $field = $(this).closest('.chs-media-field');
      $field.find('[data-chs-media-id]').val('');
      $field.find('[data-chs-media-preview]').empty();
      if ($field.attr('data-chs-media-role') === 'desktop') {
        $field.closest('[data-chs-slide-panel]').find('[data-chs-preview-media]').html('<span>No desktop image selected</span>');
      }
    });
  }

  $(function () {
    var $editor = $('[data-chs-editor]');
    if (!$editor.length) return;

    var $list = $editor.find('[data-chs-slide-list]');
    var $panels = $editor.find('[data-chs-slide-panels]');
    var $presetBar = $editor.find('[data-chs-preset-bar]');

    function rebuildTabs() {
      $list.empty();
      $panels.find('[data-chs-slide-panel]').each(function (index) {
        var heading = $(this).find('[data-chs-slide-heading]').val() || ('Slide ' + (index + 1));
        var inactive = !$(this).find('[data-chs-slide-active]').is(':checked');
        var badge = $(this).find('[data-chs-slide-badge]').val() || 'No badge';
        $list.append('<li class="chs-slide-list__item' + (inactive ? ' is-inactive' : '') + '" data-chs-slide-tab="' + index + '"><span class="dashicons dashicons-menu"></span><span class="chs-slide-list__text"><span class="chs-slide-list__label">' + heading + '</span><span class="chs-slide-list__meta">' + badge + '</span></span></li>');
        syncPreview($(this));
      });
      $list.find('[data-chs-slide-tab]').first().addClass('is-active');
      $panels.find('[data-chs-slide-panel]').hide().first().show();
      relabel($editor);
    }

    $editor.on('click', '[data-chs-slide-tab]', function () {
      var index = $(this).data('chs-slide-tab');
      $list.find('[data-chs-slide-tab]').removeClass('is-active');
      $(this).addClass('is-active');
      $panels.find('[data-chs-slide-panel]').hide().eq(index).show();
    });

    $editor.on('input change', '[data-chs-slide-heading], [data-chs-slide-badge], [data-chs-slide-eyebrow], [data-chs-slide-body], [data-chs-slide-primary-label], [data-chs-slide-secondary-label], [data-chs-slide-align], [data-chs-slide-active]', function () {
      syncPreview($(this).closest('[data-chs-slide-panel]'));
      relabel($editor);
    });

    $editor.on('click', '[data-chs-add-slide]', function () {
      var template = $('#chs-slide-template').html();
      var count = $panels.find('[data-chs-slide-panel]').length;
      $panels.append(template.replace(/__index__/g, count));
      bindMedia($panels);
      rebuildTabs();
      $list.find('[data-chs-slide-tab]').last().trigger('click');
    });

    $editor.on('click', '[data-chs-duplicate-slide]', function () {
      var $source = $(this).closest('[data-chs-slide-panel]');
      var count = $panels.find('[data-chs-slide-panel]').length;
      var template = $('#chs-slide-template').html();
      $panels.append(template.replace(/__index__/g, count));
      var $clone = $panels.find('[data-chs-slide-panel]').last();
      $source.find('[name]').each(function () {
        var name = $(this).attr('name');
        var field = name.replace(/^.*\]\[([^\]]+)\]$/, '$1');
        var $target = $clone.find('[name$="[' + field + ']"]');
        if (!$target.length) return;
        if ($(this).is(':checkbox')) {
          $target.prop('checked', $(this).is(':checked'));
        } else {
          $target.val($(this).val());
        }
      });
      $clone.find('[data-chs-media-preview]').each(function (index) {
        $(this).html($source.find('[data-chs-media-preview]').eq(index).html());
      });
      $clone.find('[data-chs-preview-media]').html($source.find('[data-chs-preview-media]').html());
      bindMedia($panels);
      rebuildTabs();
      $list.find('[data-chs-slide-tab]').last().trigger('click');
    });

    $editor.on('click', '[data-chs-open-presets]', function () {
      $presetBar.prop('hidden', !$presetBar.prop('hidden'));
    });

    $editor.on('click', '[data-chs-preset]', function () {
      var $activePanel = $panels.find('[data-chs-slide-panel]:visible').first();
      if (!$activePanel.length) return;
      applyPreset($activePanel, $(this).data('chs-preset'));
    });

    $editor.on('click', '[data-chs-remove-slide]', function () {
      $(this).closest('[data-chs-slide-panel]').remove();
      rebuildTabs();
    });

    $list.sortable({
      update: function () {
        var ordered = [];
        $list.find('[data-chs-slide-tab]').each(function () {
          ordered.push($panels.find('[data-chs-slide-panel]').eq($(this).data('chs-slide-tab')).detach());
        });
        ordered.forEach(function ($panel) { $panels.append($panel); });
        rebuildTabs();
      }
    });

    bindMedia($editor);
    rebuildTabs();
  });
})(jQuery);
