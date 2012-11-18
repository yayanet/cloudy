from django.http import HttpResponseRedirect
from django.contrib.auth.decorators import login_required

@login_required
def index(request):
    return HttpResponseRedirect('/notes/')
