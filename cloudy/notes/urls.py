from django.conf.urls import patterns, include, url

urlpatterns = patterns('notes.views',
    url(r'^$', 'index'),
)
