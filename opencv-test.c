#include "cv.h"
#include "highgui.h"

void main() {
    IplImage* img;
    img = cvLoadImage("test.jpg",1);
    cvNamedWindow("ShowImage",1);
    cvShowImage("ShowImage",img);
    cvWaitKey(0);
}