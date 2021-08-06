require('./bootstrap');

window.confirmDeleteDroid = function (event)
{
    if (confirm('Are you sure you want to delete your droid?'))
    {
        return true;
    }
    else
    {
        event.stopPropagation();
        event.preventDefault();
        return false;
    }
}
